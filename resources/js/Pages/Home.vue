<template>
    <AdminLayout>
        <v-container>
            <v-row>
                <v-col cols="12">
                    <v-card v-if="reporteAcopio !== null">
                        <v-toolbar density="compact" title="Acopio">
                        </v-toolbar>
                        <BarGraphic :data="reporteAcopio"></BarGraphic>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6">
                    <v-card v-if="reporteVentas !== null">
                        <v-toolbar density="compact" title="Ventas">
                        </v-toolbar>
                        <BarGraphic :data="reporteVentas"></BarGraphic>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6">
                    <v-card v-if="reporteCompras !== null">
                        <v-toolbar density="compact" title="Compras">
                        </v-toolbar>
                        <BarGraphic :data="reporteCompras"></BarGraphic>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/layouts/AdminLayout.vue";
import BarGraphic from "../components/BarGraphic.vue";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    plantas: Array,
});

const reporteVentas = ref(null);
const reporteAcopio = ref(null);
const reporteCompras = ref(null);

const getReporteAcopio = async () => {
    let res = await axios.get("/reportes/acopio");
    reporteAcopio.value = res?.data;
};

const getReporteVentas = async () => {
    let res = await axios.get("/reportes/ventas");
    reporteVentas.value = res?.data;
};

const getReporteCompras = async () => {
    let res = await axios.get("/reportes/compras");
    reporteCompras.value = res?.data;
};

const init = async () => {
    await getReporteAcopio();
    await getReporteVentas();
    await getReporteCompras();
};
init();
</script>
