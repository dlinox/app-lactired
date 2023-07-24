<template>
    <SimpleForm
        :formularioJson="formStructure"
        v-model="form"
        @onCancel="$emit('onCancel')"
        @onSumbit="submit"
    >
        <template #field.insu_imagen>
            <v-card variant="tonal">
                <CropCompressImage
                    :aspect-ratio="16 / 9"
                    @onCropper="
                        (preview_img = $event.blob),
                            (form.insu_imagen = $event.file)
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
                    v-if="form.insu_imagen_url && !preview_img"
                    class="mx-auto"
                    :width="300"
                    aspect-ratio="16/9"
                    cover
                    :src="form.insu_imagen_url"
                ></v-img>
            </v-card>
        </template>
    </SimpleForm>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import SimpleForm from "@/components/SimpleForm.vue";
import CropCompressImage from "@/components/CropCompressImage.vue";
import { ref } from "vue";

const emit = defineEmits(["onCancel", "onSubmit"]);
const props = defineProps({
    formData: {
        type: Object,
        default: {
            insu_nombre: "",
            insu_stock: "",
            insu_medida: "",
            insu_umed_id: null,
            insu_plan_id: null,
            insu_imagen: null,
            insu_imagen_url: null,
        },
    },
    edit: {
        type: Boolean,
        default: false,
    },
    url: String,
});

const form = useForm({ ...props.formData });

const preview_img = ref(null);

const formStructure = ref([
    {
        key: "insu_nombre",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
    },
    {
        key: "insu_stock",
        label: "Stock",
        type: "number",
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "insu_medida",
        label: "Unidad medida",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "insu_umed_id",
        label: "Unidad de medida",
        url: "/autocomplete/unidades-medida",
        type: "autocomplete",
        itemTitle: "umed_nombre",
        itemValue: "umed_id",
        required: true,
        itemsDefault: form.unidad_medida,
        cols: 12,
        colMd: 6,
    },

    {
        key: "insu_plan_id",
        label: "Planta",
        url: "/autocomplete/plantas",
        type: "autocomplete",
        itemTitle: "plan_razon_social",
        itemValue: "plan_id",
        required: true,
        itemsDefault: form.planta,
        cols: 12,
    },

    {
        key: "insu_imagen",
        label: "Imagen",
        type: "image",
        required: true,
        cols: 12,
    },
]);

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
const init = () => {};
</script>
