<template>
    <SimpleForm
        :formularioJson="formStructure"
        v-model="form"
        @onCancel="$emit('onCancel')"
        @onSumbit="submit"
    >
    </SimpleForm>
</template>

<script setup>
import SimpleForm from "@/components/SimpleForm.vue";
import { useForm } from "@inertiajs/vue3";
const emit = defineEmits(["onCancel", "onSubmit"]);
const props = defineProps({
    formData: {
        type: Object,
        default: {
            prod_nombre: "",
            prod_stock: "",
            prod_medida: "",
            prod_umed_id: null,
            prod_umed_id: null,
            prod_plan_id: null,
            prod_tpro_id: null,
        },
    },
    edit: {
        type: Boolean,
        default: false,
    },
    url: String,
});

const form = useForm({ ...props.formData });

const formStructure = [
    {
        key: "prod_tpro_id",
        label: "Tipo de producto",
        url: "/autocomplete/tipo-productos",
        type: "autocomplete",
        itemTitle: "tpro_nombre",
        itemValue: "tpro_id",
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
        key: "prod_medida",
        label: "Unidad medida",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "prod_umed_id",
        label: "Unidad de medida",
        url: "/autocomplete/unidades-medida",
        type: "autocomplete",
        itemTitle: "umed_nombre",
        itemValue: "umed_id",
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "prod_plan_id",
        label: "Planta",
        url: "/autocomplete/plantas",
        type: "autocomplete",
        itemTitle: "plan_razon_social",
        itemValue: "plan_id",
        required: true,
        cols: 12,
    },
];

const submit = async () => {
    if (props.edit) form.put(props.url, option);
    else form.post(props.url, option);
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
