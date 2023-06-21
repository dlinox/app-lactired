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
            inst_nombre: "",
            inst_naturaleza: "",
            inst_nivel: "",
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
        key: "inst_nombre",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
    },

    {
        key: "inst_naturaleza",
        label: "Naturaleza",
        type: "select",
        options: ["PÚBLICO", "PRIVADO", "PRIVADO-ONG", "EMPRESA PRIVADA"],
        required: true,
        cols: 12,
        colMd: 6
    },
    {
        key: "inst_nivel",
        label: "Nivel",
        type: "select",
        options: [
            "REGIONAL",
            "PROVINCIAL",
            "DISTRITAL ZONA AYMARA",
            "NACIONAL",
        ],
        required: true,
        cols: 12,
        colMd: 6
        
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
