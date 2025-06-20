<template>
    <SimpleForm
        :formularioJson="formStructure"
        v-model="form"
        @onCancel="$emit('onCancel')"
        @onSumbit="submit"
    >
        <template #field.prod_imagen>
            <v-card variant="tonal">
                <CropCompressImage
                    :aspect-ratio="16 / 9"
                    @onCropper="
                        (preview_img = $event.blob),
                            (form.prod_imagen = $event.file)
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

                <v-img
                    v-if="form.prod_imagen_url && !preview_img"
                    class="mx-auto"
                    :width="300"
                    aspect-ratio="16/9"
                    cover
                    :src="form.prod_imagen_url"
                ></v-img>
            </v-card>
        </template>
        <template #field.prod_decripcion_tecnica>
            <QuillEditor
                contentType="html"
                theme="snow"
                placeholder="Ingrese la descripcion tecnica del producto"
                v-model:content="form.prod_decripcion_tecnica"
            />
        </template>
    </SimpleForm>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import SimpleForm from "@/components/SimpleForm.vue";
import CropCompressImage from "@/components/CropCompressImage.vue";

const emit = defineEmits(["onCancel", "onSubmit"]);
const props = defineProps({
    productTypes: {
        type: Array,
        default: () => [],
    },
    unitMeasurements: {
        type: Array,
        default: () => [],
    },
    formData: {
        type: Object,
        default: {
            prod_nombre: "",
            prod_stock: "",
            prod_medida: "",
            prod_umed_id: null,
            prod_tpro_id: null,
            prod_imagen: null,
            prod_imagen_url: null,
            prod_decripcion_tecnica: "",
        },
    },
    edit: {
        type: Boolean,
        default: false,
    },
    url: String,
});

const preview_img = ref(null);

const form = useForm({ ...props.formData });

const formStructure = [
    {
        key: "prod_tpro_id",
        label: "Tipo de producto",
        type: "combobox",
        options: props.productTypes,
        required: true,
        cols: 12,
    },
    {
        key: "prod_nombre",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
    },
    {
        key: "prod_stock",
        label: "Stock",
        type: "number",
        required: true,
        cols: 12,
    },

    {
        key: "prod_umed_id",
        label: "Unidad de medida",
        type: "combobox",
        options: props.unitMeasurements,
        required: true,
        cols: 12,
        colMd: 4,
    },

    {
        key: "prod_medida",
        label: "Presentacion",
        type: "text",
        required: true,
        cols: 12,
        colMd: 4,
    },
    {
        key: "prod_precio_venta",
        label: "Precio de venta",
        type: "number",
        required: true,
        cols: 12,
        colMd: 4,
    },
    {
        key: "prod_decripcion_tecnica",
        label: "Descripcion tecnica",
        type: "richt-text",
        required: true,
        cols: 12,
    },
    {
        key: "prod_imagen",
        label: "Imagen Referencial",
        type: "photo",
        required: true,
        cols: 12,
    },
];

const submit = async () => {
    form.post(props.url, option);
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
</script>
