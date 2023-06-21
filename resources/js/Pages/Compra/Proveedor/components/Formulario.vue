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
            prov_dni: "",
            prov_paterno: "",
            prov_materno: "",
            prov_nombres: "",
            prov_sexo: "",
            prov_precio_alta: 0.00,
            prov_precio_baja: 0.00,
            prov_latitud: "",
            prov_longitud: "",
            prov_activo: true,
            prov_plan_id: "",
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
        key: "prov_dni",
        label: "Nro DNI",
        type: "text",
        required: true,
        cols: 12,
    },
    {
        key: "prov_nombres",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
    },
    {
        key: "prov_paterno",
        label: "Paterno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "prov_materno",
        label: "Materno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "prov_precio_alta",
        label: "Precio alta",
        type: "number",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "prov_precio_baja",
        label: "Precio baja",
        type: "number",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "prov_latitud",
        label: "Latitud",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "prov_longitud",
        label: "Longitud",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "prov_plan_id",
        label: "Planta",
        type: "autocomplete",
        url: "/autocomplete/plantas",
        itemTitle: "plan_razon_social",
        itemValue: "plan_id",
        required: true,
        cols: 12,
    },

    {
        key: "prov_sexo",
        label: "Sexo",
        type: "select",
        options: [
            { value: "F", title: "Femenino" },
            { value: "M", title: "Masculino" },
        ],
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "prov_activo",
        label: "Activo",
        type: "checkbox",
        required: false,
        cols: 6,
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
