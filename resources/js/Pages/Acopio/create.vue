<template>
    <AdminLayout>
        <HeadingPage title="Acopio de Leche" subtitle="Registrar compra">
        </HeadingPage>

        <v-container fluid>
            <v-row>
                <v-col cols="12" md="8">
                    <v-card>
                        <v-toolbar title="Compra" density="compact">
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
                                    <v-card variant="tonal">
                                        <CropCompressImage
                                            :aspect-ratio="16 / 9"
                                            @onCropper="
                                                (preview_img = $event.blob),
                                                    (form.comp_imagen =
                                                        $event.file)
                                            "
                                        />

                                        <v-img
                                            v-if="preview_img"
                                            class="mx-auto"
                                            :width="300"
                                            aspect-ratio="16/9"
                                            cover
                                            :src="preview_img"
                                        ></v-img>
                                    </v-card>
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
                                                    Nombre
                                                </th>
                                                <th class="text-left">Stock</th>

                                                <th class="text-left">
                                                    U. Med.
                                                </th>

                                                <th class="text-left">
                                                    Medida
                                                </th>
                                                <th class="text-left">
                                                    Catidad
                                                </th>
                                                <th class="text-left">
                                                    Precio
                                                </th>
                                                <th class="text-left">
                                                    Imoprte
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="item in form.comp_detalle"
                                                :key="item.insu_id"
                                            >
                                                <td>{{ item.insu_nombre }}</td>
                                                <td>{{ item.insu_stock }}</td>
                                                <td>{{ item.umed_nombre }}</td>
                                                <td>
                                                    {{ item.insu_medida }}
                                                    {{
                                                        item.unidad_medida
                                                            .umed_simbolo
                                                    }}
                                                </td>
                                                <td>
                                                    <v-text-field
                                                        v-model="item.cantidad"
                                                        :clearable="false"
                                                        type="number"
                                                        density="compact"
                                                    ></v-text-field>
                                                </td>
                                                <td>
                                                    <v-text-field
                                                        v-model="item.precio"
                                                        :clearable="false"
                                                        type="number"
                                                        density="compact"
                                                    ></v-text-field>
                                                </td>
                                                <td>
                                                    <v-text-field
                                                        v-model="item.importe"
                                                        :clearable="false"
                                                        type="number"
                                                        density="compact"
                                                    ></v-text-field>
                                                </td>
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
                                    <v-radio-group
                                        inline
                                        v-model="form.comp_tipo_pago"
                                    >
                                        <v-radio
                                            label="Al contado"
                                            value="0"
                                        ></v-radio>
                                        <v-radio
                                            label="Al credito"
                                            value="1"
                                        ></v-radio>
                                    </v-radio-group>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="form.comp_fecha"
                                        label="Fecha"
                                        type="date"
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-select
                                        v-model="form.comp_tipo_comprobante"
                                        label="Tipo de comporbante"
                                        :items="itemsComprobante"
                                        @update:model-value="
                                            changeTipoComporbante
                                        "
                                    ></v-select>
                                </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        v-model="form.comp_serie"
                                        label="Serie"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="8">
                                    <v-text-field
                                        v-model="form.comp_numero"
                                        label="Número"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-list-item
                                        v-for="item in form.comp_detalle"
                                        :key="item.insu_id"
                                        :title="item.insu_nombre"
                                    >
                                        <template v-slot:append>
                                            S/.
                                            {{
                                                (
                                                    (item.cantidad ?? 0) *
                                                    (item.precio ?? 0)
                                                ).toFixed(2)
                                            }}
                                        </template>
                                    </v-list-item>
                                    <v-divider></v-divider>

                                    <v-list-item title="Sub total">
                                        <template v-slot:append>
                                            S/.
                                            {{ subtotal.toFixed(2) }}
                                        </template>
                                    </v-list-item>
                                    <v-divider></v-divider>

                                    <v-list-item title="El monto incluye IGV">
                                        <template v-slot:append>
                                            <v-checkbox
                                                v-model="incluyeIgv"
                                                label=""
                                            ></v-checkbox>
                                        </template>
                                    </v-list-item>

                                    <v-list-item title="IGV (18%)">
                                        <template v-slot:append>
                                            S/.
                                            {{ igv.toFixed(2) }}
                                        </template>
                                    </v-list-item>
                                    <!-- 
                                  <v-list-item title="Descuento">
                                      <template v-slot:append>
                                          <v-text-field
                                          style="width: 100px;"
                                              prefix="S/. "
                                              variant="underlined"
                                              :clearable="false"
                                              type="number"
                                              density="compact"
                                          ></v-text-field>
                                      </template>
                                  </v-list-item> -->

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
    insumo: Object,
});

const incluyeIgv = ref(false);

const preview_img = ref(null);

const form = useForm({
    comp_serie: props.defaults.serie,
    comp_numero: props.defaults.numero,
    comp_correlativo: "",
    comp_fecha: props.defaults.fecha,
    comp_subtotal: 0.0,
    comp_total: 0.0,
    comp_importe: 0.0,
    comp_igv: 0.0,
    //comp_estado: "",
    comp_tipo_pago: "0",
    comp_tipo: 0,
    comp_estado_deuda: 0,
    comp_imagen: null,
    comp_plan_id: 1, //cambiar
    comp_prov_id: null,
    comp_tipo_comprobante: props.defaults.comprobante,
    comp_detalle: [{ ...props.insumo }],
});

const subtotal = computed(() => {
    let res = form?.comp_detalle?.reduce(
        (accumulator, item) =>
            accumulator + parseInt(item.cantidad) * parseFloat(item.precio),
        0
    );
    res = incluyeIgv.value ? res - parseFloat(igv.value) : res;
    form.comp_subtotal = res;
    return res;
});
const igv = computed(() => subtotal.value * 0.18);
const total = computed(() => {
    let res = parseFloat(subtotal.value) + parseFloat(igv.value);
    form.comp_total = res;
    return res;
});

const itemsComprobante = ["FACTURA", "BOLETA"];

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
            changeTipoComporbante(form.comp_tipo_comprobante);
        },
    });
};
</script>
