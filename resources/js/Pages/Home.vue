<template>
    <AdminLayout>
        <v-container fluid>
            <v-row>
                <v-col cols="8" md="10"></v-col>
                <v-col cols="4" md="2">
                    <v-select
                        v-model="year"
                        :items="yearOptions"
                        label="Año"
                        density="compact"
                        class="text-black"
                        :clearable="false"
                        @update:model-value="router.get(url + `?anio=${year}`, {
                            preserveState: true,
                            preserveScroll: true,
                        })"
                    />
                </v-col>
                <v-col cols="12" md="6" lg="3">
                    <v-card class="mx-auto" color="primary">
                        <v-card-text>
                            <div>Inversiónes</div>

                            <p class="text-h6 font-weight-black">
                                Activos fijos
                            </p>

                            <p
                                class="text-h5 font-weight-black text-end mt-3 text-white"
                            >
                                S/ {{ activosFijos.toFixed(2) }}
                            </p>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="6" lg="3">
                    <v-card class="mx-auto">
                        <v-card-text>
                            <div>
                                Inversiónes -
                                <i class="font-weight-black">{{ anio }}</i>
                            </div>

                            <p class="text-h6 font-weight-black">
                                Capital de trabajo
                            </p>

                            <p
                                class="text-h5 font-weight-black text-end mt-3 text-info"
                            >
                                S/ {{ capitalTrabajo.toFixed(2) }}
                            </p>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6" lg="3">
                    <v-card class="mx-auto">
                        <v-card-text>
                            <div>
                                <span class="font-weight-black text-blue-darken-4">
                                    S/ {{ proyeccionVentas.toFixed(2) }}
                                </span>
                                (Proyección - <i>{{ anio }}</i> )
                            </div>

                            <p class="text-h6 font-weight-black">Ventas</p>

                            <p
                                class="text-h5 font-weight-black text-end text-info mt-3"
                            >
                                S/
                                {{ ventas.toFixed(2) }}
                            </p>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6" lg="3">
                    <v-card class="mx-auto">
                        <v-card-text>
                            <div>
                                <span class="font-weight-black text-blue-darken-4">
                                    S/ {{ proyeccionCompras.toFixed(2) }}
                                </span>
                                (Proyección - <i>{{ anio }}</i> )
                            </div>

                            <p class="text-h6 font-weight-black">Compras</p>

                            <p
                                class="text-h5 font-weight-black text-end mt-3 text-info"
                            >
                                S/ {{ compras.toFixed(2) }}
                            </p>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12">
                    <v-card v-if="reporteAcopio !== null">
                        <v-toolbar density="compact" title="Acopio">
                        </v-toolbar>
                        <BarGraphic
                            :data="reporteAcopio"
                            label="Acopio (S/.)"
                        ></BarGraphic>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6">
                    <v-card v-if="reporteVentas !== null">
                        <v-toolbar density="compact" title="Ventas">
                        </v-toolbar>
                        <BarGraphic
                            :data="reporteVentas"
                            label="Ventas (S/.)"
                        ></BarGraphic>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6">
                    <v-card v-if="reporteCompras !== null">
                        <v-toolbar density="compact" title="Compras">
                        </v-toolbar>
                        <BarGraphic
                            :data="reporteCompras"
                            label="Compras (S/.)"
                        ></BarGraphic>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import axios from "axios";

import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import AdminLayout from "@/layouts/AdminLayout.vue";
import BarGraphic from "../components/BarGraphic.vue";

const props = defineProps({
    plantas: Array,
    anio: Number,
    activosFijos: Number,
    capitalTrabajo: Number,
    ventas: Number,
    proyeccionVentas: Number,
    compras: Number,
    proyeccionCompras: Number,
});

const reporteVentas = ref(null);
const reporteAcopio = ref(null);
const reporteCompras = ref(null);

const year = ref(props.anio);
const yearOptions = ref([]);
const url = "/";

const getReporteAcopio = async () => {
    let res = await axios.get("/reportes/acopio?anio=" + year.value);
    reporteAcopio.value = res?.data;
};

const getReporteVentas = async () => {
    let res = await axios.get("/reportes/ventas?anio=" + year.value);
    reporteVentas.value = res?.data;
};

const getReporteCompras = async () => {
    let res = await axios.get("/reportes/compras?anio=" + year.value);
    reporteCompras.value = res?.data;
};

const init = async () => {
    await getReporteAcopio();
    await getReporteVentas();
    await getReporteCompras();
    for (let i = 2020; i <= 2100; i++) {
        yearOptions.value.push(i);
    }
};
init();
</script>
