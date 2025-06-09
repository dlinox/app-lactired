<template>
    <SimpleForm
        :formularioJson="formStructure"
        v-model="form"
        @onCancel="$emit('onCancel')"
        @onSumbit="submit"
        ref="formRef"
    >
        <template #field.prod_insumos>
            <v-card
                variant="flat"
                :title="`${props.productName}`"
                subtitle="Lista de insumos para la elaboración del producto"
            >
                <v-card-item class="px-0">
                    <v-combobox
                        class="mt-2"
                        v-model="form.prod_insumos"
                        multiple
                        chips
                        deletable
                        item-value="insu_id"
                        item-title="insu_name"
                        :items="insumosItems"
                        label="Seleccione insumos"
                        return-object
                        :disabled="loadingForm"
                        clearable
                    />
                </v-card-item>
                <v-card-item class="px-0">
                    <v-row
                        dense
                        v-for="(item, index) in form.prod_insumos"
                        :key="index"
                        class="border-t mt-2"
                    >
                        <v-col cols="7" md="4">
                            <v-text-field
                                class="mt-2"
                                readonly
                                :clearable="false"
                                v-model="item.insu_name"
                                label="Nombre del insumo"
                                :disabled="loadingForm"
                                :rules="[
                                    (v) =>
                                        !!v || 'Nombre del insumo es requerido',
                                ]"
                            />
                        </v-col>
                        <v-col cols="5" md="3">
                            <v-select
                                class="mt-2"
                                v-model="item.insu_unit_measurement_id"
                                :items="props.unitMeasurements"
                                label="Unidad de medida"
                                :disabled="loadingForm"
                                :rules="[
                                    (v) =>
                                        !!v || 'Unidad de medida es requerida',
                                ]"
                                :clearable="false"
                            />
                        </v-col>
                        <v-col cols="5" md="2">
                            <v-text-field
                                class="mt-2"
                                v-model.number="item.insu_quantity"
                                label="Cantidad"
                                :rules="[
                                    (v) => !!v || 'Cantidad es requerida',
                                    (v) =>
                                        v > 0 ||
                                        'La cantidad debe ser mayor a 0',
                                ]"
                                :clearable="false"
                                :disabled="loadingForm"
                            />
                        </v-col>

                        <v-col cols="5" md="2">
                            <v-text-field
                                class="mt-2"
                                v-model.number="item.insu_price"
                                label="Precio unitario"
                                :clearable="false"
                                :rules="[
                                    (v) =>
                                        !!v || 'Precio unitario es requerido',
                                    (v) =>
                                        v >= 0 ||
                                        'El precio unitario debe ser mayor o igual a 0',
                                ]"
                                :disabled="loadingForm"
                            />
                        </v-col>
                        <v-col cols="2" md="1">
                            <v-btn icon variant="text" color="info" block>
                                <b>
                                    <small>
                                        {{
                                            (
                                                item.insu_quantity *
                                                item.insu_price
                                            ).toFixed(2)
                                        }}
                                    </small>
                                </b>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-item>
            </v-card>
        </template>
    </SimpleForm>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import SimpleForm from "@/components/SimpleForm.vue";

import { itemsForSelect as getInusosForSelect } from "@/Pages/Almacen/Insumo/services/insumo.services";
import { getInsumosByProductoId } from "@/Pages/Almacen/Producto/services/producto.services";

const emit = defineEmits(["onCancel", "onSubmit"]);
const props = defineProps({
    unitMeasurements: {
        type: Array,
        default: () => [],
    },
    productId: {
        type: [Number, String],
        required: true,
    },
    productName: {
        type: String,
        required: true,
    },
    url: String,
});

const loadingForm = ref(false);
const formRef = ref(null);
const form = useForm({
    prod_id: null,
    prod_insumos: [],
});
const insumos = ref([]);
const insumosItems = ref([]);

const itemInsumo = {
    insu_id: null,
    insu_name: "",
    insu_quantity: 0,
    insu_unit_measurement_id: null,
    insu_price: 0,
};

const formStructure = [
    {
        key: "prod_insumos",
        label: "Insumos",
        type: "object",
        required: true,
        cols: 12,
    },
];

const submit = async () => {
    let url = props.url + "/" + form.prod_id + "/insumos";
    form.post(url, option);
};

const option = {
    onSuccess: (page) => {
        console.log("onSuccess");
        emit("onCancel");
    },
    onError: (errors) => {
        console.log("onError");
    },
    onFinish: (visit) => {
        console.log("onFinish");
    },
};

const initForm = async () => {
    form.reset();
    form.prod_id = props.productId;
    form.prod_insumos = [];
    insumos.value = [];

    loadingForm.value = true;
    insumos.value = await getInusosForSelect();
    insumosItems.value = insumos.value.map((item) => {
        return {
            ...itemInsumo,
            insu_id: item.value,
            insu_name: item.title,
        };
    });

    let insumosByProducto = await getInsumosByProductoId(props.productId);
    if (insumosByProducto.length > 0) {
        form.prod_insumos = insumosByProducto;
    }
    loadingForm.value = false;
};

initForm();
</script>
