<template>
    <SimpleForm
        :formularioJson="formStructure"
        v-model="form"
        @onCancel="$emit('onCancel')"
        @onSumbit="submit"
    >
        <template #field.user_plan_id>
            <v-text-field
                v-model="form.user_plan_id"
                label="Seleccione una planta"
                :error-messages="form.errors.user_plan_id"
            ></v-text-field>
        </template>
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
            name: "",
            paterno: "",
            materno: "",
            email: "",
            dni: "",
            password: "",
            user_plan_id: "",
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
        key: "dni",
        label: "DNI",
        type: "text",
        required: true,
        cols: 12,
        colMd: 5,
    },

    {
        key: "name",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        colMd: 7,
    },

    {
        key: "paterno",
        label: "Paterno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "materno",
        label: "Materno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "email",
        label: "Correo",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "password",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "user_plan_id",
        label: "Seleccione una planta",
        type: "select",
        required: true,
        cols: 12,
        options: [""],
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
