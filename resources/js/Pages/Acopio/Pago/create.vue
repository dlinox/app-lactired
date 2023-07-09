<template>
    <AdminLayout>
        <HeadingPage title="Pago" subtitle="Registrar pago"> </HeadingPage>
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="8">
                    <v-card :loading="pagoDetalleLoading">
                        <v-toolbar title="Pago" density="compact"> </v-toolbar>

                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-autocomplete
                                        no-data-text="No tiene pagos pendientes"
                                        label="Proveedores"
                                        item-value="prov_id"
                                        item-title="detalle"
                                        :items="defaults.proveedores"
                                        v-model="form.pago_prov_id"
                                        @update:model-value="onSelectProveedor"
                                    />
                                </v-col>

                                <v-col cols="12">
                                    <v-table
                                        density="compact"
                                        fixed-header
                                        style="border: 1px solid #eee"
                                    >
                                        <thead>
                                            <tr>
                                                <th class="text-left"></th>

                                                <th class="text-left">
                                                    Serie-Numero
                                                </th>
                                                <th class="text-left">Fecha</th>
                                                <th class="text-left">
                                                    Total S/.
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="item in pagoDetalle"
                                                :key="item.comp_id"
                                            >
                                                <td>
                                                    <v-checkbox
                                                        v-model="
                                                            form.pago_detalle
                                                        "
                                                        :value="item"
                                                    ></v-checkbox>
                                                </td>
                                                <td>
                                                    {{ item.comp_serie }} -
                                                    {{ item.comp_numero }}
                                                </td>
                                                <td>{{ item.comp_fecha }}</td>
                                                <td>{{ item.comp_total }}</td>
                                            </tr>
                                        </tbody>
                                    </v-table>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-col>
                <v-col cols="12" md="4">
                    <v-card>
                        <v-toolbar title="Detalle" density="compact">
                        </v-toolbar>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="form.pago_fecha"
                                        label="Fecha"
                                        type="date"
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field
                                        v-model="form.pago_numero"
                                        label="Número"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-list-item
                                        v-for="item in form.pago_detalle"
                                        :key="item.comp_id"
                                        :title="`${item.comp_serie}-${item.comp_numero}`"
                                    >
                                        <template v-slot:append>
                                            S/. {{ item.comp_total }}
                                        </template>
                                    </v-list-item>
                                    <v-divider></v-divider>

                                    <v-list-item title="Total">
                                        <template v-slot:append>
                                            S/.
                                            {{ total }}
                                        </template>
                                    </v-list-item>
                                    <v-divider></v-divider>
                                </v-col>

                                <v-col>
                                    <v-btn
                                        :loading="form.processing"
                                        :disabled="
                                            form.pago_detalle.length === 0
                                                ? true
                                                : false
                                        "
                                        block
                                        @click="guardar"
                                    >
                                        PAGAR
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import { computed, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import axios from "axios";

const props = defineProps({
    defaults: Object,
});

const pagoDetalle = ref([]);
const pagoDetalleLoading = ref(false);
const form = useForm({
    pago_numero: props.defaults.numero,
    pago_monto: 0.0,
    pago_fecha: props.defaults.fecha,
    pago_prov_id: null,
    pago_plan_id: 1, // back
    pago_detalle: [],
});

const total = computed(() => {
    let res = form?.pago_detalle?.reduce(
        (accumulator, item) => accumulator + parseFloat(item.comp_total),
        0
    );

    form.pago_monto = res;
    return res;
});

const onSelectProveedor = async (val) => {
    if (val === null) {
        form.pago_detalle = [];
        pagoDetalle.value = [];
        return;
    }

    pagoDetalleLoading.value = true;
    let res = await axios.get("/acopio/pagos/detalle/" + val);
    pagoDetalle.value = res.data;
    pagoDetalleLoading.value = false;
};

const guardar = () => {
    form.post("/acopio/pagos", {
        onSuccess: () => {
            form.reset();
            form.pago_detalle = [];
            pagoDetalle.value = [];
            form.pago_numero = (parseInt(form.pago_numero) + 1)
                .toString()
                .padStart(10, "0");
        },
    });
};
</script>
