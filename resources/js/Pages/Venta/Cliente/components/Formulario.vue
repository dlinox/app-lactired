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
            clie_tipo_documento: "DNI",
            clie_nro_documento: "",
            //clie_tipo_persona: "",
            clie_nombres: "",
            clie_paterno: "",
            clie_materno: "",
            clie_direccion: "",
            clie_telefono: "",
            clie_correo: "",
            clie_direccion: "",
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
        key: "clie_tipo_documento",
        label: "Tipo de documento",
        type: "select",
        options: ["RUC", "DNI", "CE"],
        required: true,
        cols: 12,
        colMd: 4,
    },
    {
        key: "clie_nro_documento",
        label: "Nro de documento",
        type: "number",
        required: true,
        cols: 12,
        colMd: 8,
    },

    {
        key: "clie_nombres",
        label: "Nombres",
        type: "text",
        required: true,
        cols: 12,
        colMd: 12,
    },

    {
        key: "clie_paterno",
        label: "Paterno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "clie_materno",
        label: "Materno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "clie_telefono",
        label: "Telefono",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "clie_correo",
        label: "Correo",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "clie_direccion",
        label: "Dirección",
        type: "text",
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
