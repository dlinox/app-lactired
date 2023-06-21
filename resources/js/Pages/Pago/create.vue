<template>
    <AdminLayout>
        <HeadingPage title="Pago" subtitle="Registrar pago">
        </HeadingPage>

        <v-container fluid>
            <v-row>
                <v-col cols="12" md="8">
                    <v-card>
                        <v-toolbar title="Pago" density="compact">
                        </v-toolbar>

                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <SimpleAutocomplete
                                        url="/autocomplete/proveedores"
                                        item-title="proveedor"
                                        item-value="prov_id"
                                        label="Buscar Proveedor"
                                        v-model="form.comp_prov_id"
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
                                                <th class="text-left">
                                                    Serie-Numero
                                                </th>
                                                <th class="text-left">
                                                    Fecha
                                                </th>
                                                <th class="text-left">
                                                    Total S/.
                                                </th>
                                            </tr>
                                        </thead>
                                        <!-- <tbody>
                                            <tr
                                                v-for="item in form.comp_detalle"
                                                :key="item.insu_id"
                                            >
                                                <td>{{ item.insu_nombre }}</td>
                                                <td>{{ item.insu_stock }}</td>
                                                <td>{{ item.umed_nombre }}</td>
                                            </tr>
                                        </tbody> -->
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
                                        :key="item.insu_id"
                                        :title="item.insu_nombre"
                                    >
                                        <template v-slot:append>
                                            S/.
                                            {{
                                                (
                                                    (item.comp_total ?? 0)
                                                ).toFixed(2)
                                            }}
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
                                    <v-btn block @click="guardar">
                                        Guardar
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
import SimpleAutocomplete from "../../components/SimpleAutocomplete.vue";
import CropCompressImage from "../../components/CropCompressImage.vue";

const props = defineProps({
    defaults: Object,
});


const form = useForm({
    pago_numero: props.defaults.numero,
    pago_monto: 0.0,
    pago_fecha: props.defaults.fecha,
    pago_prov_id: '',
    pago_plan_id: '1',
    pago_detalle: [],
});


const total = computed(() => {
    let res = form?.pago_detalle?.reduce(
        (accumulator, item) =>
            accumulator + parseFloat(item.comp_total),
        0
    );
    return res;
});


const changeTipoComporbante = (val) => {
    router.visit("/acopio/create/?comprobante=" + val, {
        preserveScroll: true,
        preserveState: true,
        only: ["defaults"],
        onFinish: () => {
            form.comp_serie = props.defaults.serie;
            form.comp_numero = props.defaults.numero;
        },
        onSuccess: (page) => {
            form.comp_serie = page.props.defaults.serie;
            form.comp_numero = page.props.defaults.numero;
            preview_img.value = null;
        },
    });
};

const guardar = () => {
    form.post("/acopio", {
        onSuccess: () => {
            form.reset();
            //changeTipoComporbante(form.comp_tipo_comprobante);
        },
    });
};
</script>
