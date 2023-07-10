<template>
    <v-card class="mb-4" variant="tonal">
        <v-card-item style="height: 200px">
            <div id="mapContainer" style="height: 400px"></div>
        </v-card-item>
    </v-card>

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
import { onMounted } from "vue";
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
            prov_precio_alta: 0.0,
            prov_precio_baja: 0.0,
            prov_latitud: "",
            prov_longitud: "",
            prov_activo: true,
            prov_plan_id: null,
        },
    },
    edit: {
        type: Boolean,
        default: false,
    },
    url: String,
});

const latlng =
    props.formData.prov_latitud && props.formData.prov_longitud
        ? [props.formData.prov_latitud, props.formData.prov_longitud]
        : [-15.284185114076433, -70.04000478753159];

onMounted(() => {
    const map = L.map("mapContainer").setView(latlng, 7);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "© OpenStreetMap contributors",
    }).addTo(map);

    const marker = L.marker(latlng).addTo(map);

    map.on("click", (event) => {
        const { lat, lng } = event.latlng;
        marker.setLatLng([lat, lng]);
        form.prov_latitud = lat;
        form.prov_longitud = lng;
    });
});

const form = useForm({ ...props.formData });

const formStructure = [
    {
        key: "prov_dni",
        label: "Nro DNI",
        type: "text",
        required: true,
        cols: 12,
        colMd: 4,
    },
    {
        key: "prov_nombres",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        colMd: 8,
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
        readonly: true,
        clearable: false,
        cols: 12,
        colMd: 6,
    },
    {
        key: "prov_longitud",
        label: "Longitud",
        type: "text",
        required: true,
        readonly: true,
        clearable: false,
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
