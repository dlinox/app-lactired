<template>
    <AdminLayout>
        <HeadingPage title="Ventas" subtitle="Registrar venta"> </HeadingPage>

        <v-container fluid class="pt-0">
            <v-row>
                <v-col cols="12" md="8">
                    <v-card>
                        <v-toolbar title="Venta" density="compact"> </v-toolbar>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <SimpleAutocomplete
                                        url="/autocomplete/clientes"
                                        item-title="cliente"
                                        item-value="clie_id"
                                        label="Buscar Cliente"
                                        v-model="form.vent_clie_id"
                                        :error-messages="
                                            form.errors.vent_clie_id
                                        "
                                    />
                                </v-col>

                                <v-col cols="12">
                                    <SimpleAutocomplete
                                        url="/autocomplete/productos"
                                        item-title="prod_nombre"
                                        item-value="prod_id"
                                        label="Buscar Prouctos"
                                        v-model="form.vent_detalle"
                                        multiple
                                        item-custom
                                        chips
                                        closable-chips
                                        return-object
                                        v-model:object="productos"
                                        :error-messages="
                                            form.errors.vent_detalle
                                        "
                                    >
                                        <template
                                            v-slot:custom="{ props, item }"
                                        >
                                            <v-list-item
                                                v-bind="props"
                                                :title="item?.raw?.prod_nombre"
                                                :subtitle="
                                                    item?.raw?.prod_stock
                                                "
                                            ></v-list-item>
                                        </template>
                                    </SimpleAutocomplete>
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
                                                v-for="(
                                                    item, index
                                                ) in form.vent_detalle"
                                                :key="item.prod_id"
                                            >
                                                <td>{{ item.prod_nombre }}</td>
                                                <td>{{ item.prod_stock }}</td>
                                                <td>{{ item.umed_nombre }}</td>
                                                <td>
                                                    {{ item.prod_medida }}
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
                                                        :error-messages="
                                                            form.errors[
                                                                `vent_detalle.${index}.cantidad`
                                                            ]
                                                        "
                                                    ></v-text-field>
                                                </td>
                                                <td>
                                                    <v-text-field
                                                        v-model="item.precio"
                                                        :clearable="false"
                                                        type="number"
                                                        density="compact"
                                                        :error-messages="
                                                            form.errors[
                                                                `vent_detalle.${index}.precio`
                                                            ]
                                                        "
                                                    ></v-text-field>
                                                </td>
                                                <td>
                                                    <v-text-field
                                                        v-model="item.importe"
                                                        :clearable="false"
                                                        type="number"
                                                        density="compact"
                                                        :error-messages="
                                                            form.errors[
                                                                `vent_detalle.${index}.importe`
                                                            ]
                                                        "
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
                                        v-model="form.vent_tipo_pago"
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
                                        v-model="form.vent_fecha"
                                        label="Fecha"
                                        type="date"
                                        :error-messages="form.errors.vent_fecha"
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-select
                                        v-model="form.vent_tipo_comprobante"
                                        label="Tipo de comporbante"
                                        :items="itemsComprobante"
                                        @update:model-value="
                                            changeTipoComporbante
                                        "
                                        :error-messages="
                                            form.errors.vent_tipo_comprobante
                                        "
                                    ></v-select>
                                </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        v-model="form.vent_serie"
                                        label="Serie"
                                        :error-messages="form.errors.vent_serie"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="8">
                                    <v-text-field
                                        v-model="form.vent_numero"
                                        label="Número"
                                        :error-messages="
                                            form.errors.vent_numero
                                        "
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-card variant="tonal">
                                        <v-list-item
                                            v-for="item in form.vent_detalle"
                                            :key="item.prod_id"
                                            :title="item.prod_nombre"
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
                                    </v-card>
                                    <v-divider></v-divider>

                                    <v-list-item title="Sub total">
                                        <template v-slot:append>
                                            S/.
                                            {{ subtotal }}
                                        </template>

                                        <template #subtitle>
                                            <small class="text-red">{{
                                                form.errors.vent_subtotal
                                            }}</small>
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
                                        <template #subtitle>
                                            <small class="text-red">{{
                                                form.errors.vent_total
                                            }}</small>
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
import { computed, ref, watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import SimpleAutocomplete from "../../components/SimpleAutocomplete.vue";

const props = defineProps({
    defaults: Object,
});

const productos = ref([]);
const incluyeIgv = ref(false);

const form = useForm({
    vent_serie: props.defaults.serie,
    vent_numero: props.defaults.numero,
    vent_correlativo: "",
    vent_fecha: props.defaults.fecha,
    vent_subtotal: 0.0,
    vent_total: 0.0,
    //vent_estado: "",
    vent_tipo_pago: "0",
    vent_clie_id: null,
    vent_plan_id: props.defaults.planta, //se tiene que cambiar
    vent_tipo_comprobante: props.defaults.comprobante,
    vent_detalle: [],
});

const changeTipoComporbante = (val) => {
    router.visit("/ventas/create/?comprobante=" + val, {
        preserveScroll: true,
        preserveState: true,
        only: ["defaults"],
        onFinish: () => {
            form.vent_serie = props.defaults.serie;
            form.vent_numero = props.defaults.numero;
        },
        onSuccess: (page) => {
            form.vent_serie = page.props.defaults.serie;
            form.vent_numero = page.props.defaults.numero;
            console.log(page);
        },
    });
};

const subtotal = computed(() => {
    let res = form?.vent_detalle?.reduce(
        (accumulator, item) =>
            accumulator + parseInt(item.cantidad) * parseFloat(item.precio),
        0
    );

    res = incluyeIgv.value ? res - parseFloat(igv.value) : res;
    form.vent_subtotal = res;
    return res;
});

const igv = computed(() => subtotal.value * 0.18);

const total = computed(() => {
    let res = parseFloat(subtotal.value) + parseFloat(igv.value);
    form.vent_total = res;
    return res;
});

const itemsComprobante = ["FACTURA", "BOLETA"];

const guardar = async () => {
    // const { valid } = await formRef.value.validate();
    // if (!valid) return;
    form.post("/ventas", {
        onSuccess: () => {
            form.reset();
            changeTipoComporbante(form.vent_tipo_comprobante);
        },
    });
};
</script>
