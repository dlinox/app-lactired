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
import { computed, ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import SimpleForm from "@/components/SimpleForm.vue";

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
        default: {},
    },
    edit: {
        type: Boolean,
        default: false,
    },
    url: String,
});

const form = useForm({ ...props.formData });

const formStructure = computed(() =>
    [
        {
            key: "inver_tipo",
            label: "Tipo de inversión",
            type: "select",
            options: [
                { value: "Activo Fijo", title: "Activo Fijo" },
                { value: "Capital de Trabajo", title: "Capital de Trabajo" },
            ],
            required: true,
            cols: 12,
        },
        {
            key: "inver_rubro",
            label: "Rubro",
            type: "text",
            required: true,
            cols: 12,
        },
        {
            key: "inver_cantidad",
            label: "Cantidad",
            type: "number",
            required: true,
            cols: 4,
        },
        {
            key: "inver_valor_unitario",
            label: "Valor unitario",
            type: "number",
            required: true,
            cols: 4,
        },
        {
            key: "inver_total",
            label: "Total",
            type: "number",
            required: true,
            cols: 4,
            clearable: false,
            readonly: true,
        },

        form.inver_tipo === "Capital de Trabajo"
            ? {
                  key: "inver_periodo",
                  label: "Mes y año de inversión",
                  type: "month",
                  required: true,
                  cols: 12,
              }
            : null,
    ].filter(Boolean)
);


watch(
    () => form.inver_cantidad,
    (newValue) => {
        if (newValue && form.inver_valor_unitario) {
            form.inver_total = newValue * form.inver_valor_unitario;
            form.inver_total = parseFloat(form.inver_total.toFixed(2));
        }
    }
);
watch(
    () => form.inver_valor_unitario,
    (newValue) => {
        if (newValue && form.inver_cantidad) {
            form.inver_total = newValue * form.inver_cantidad;
            form.inver_total = parseFloat(form.inver_total.toFixed(2));
        }
    }
);

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

const initForm = async () => {
    form.reset();
};

initForm();
</script>
