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
import { ref } from "vue";
import SimpleForm from "@/components/SimpleForm.vue";
import { useForm } from "@inertiajs/vue3";
const emit = defineEmits(["onCancel", "onSubmit"]);
const props = defineProps({
    formData: {
        type: Object,
        default: {
            ncap_nombre: "",
        },
    },
    edit: {
        type: Boolean,
        default: false,
    },
});

const form = useForm({ ...props.formData });

const formStructure = [
    {
        key: "ncap_nombre",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
    },
];

const formUrl = props.edit
    ? "/config/empresa/nivel-capacitaciones/" + props.formData?.ncap_id
    : "/config/empresa/nivel-capacitaciones";

const submit = async () => {
    if (props.edit) form.put(formUrl, option);
    else form.post(formUrl, option);
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
