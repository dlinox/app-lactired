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
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import L from "leaflet";
import SimpleForm from "@/components/SimpleForm.vue";

const emit = defineEmits(["onCancel", "onSubmit"]);
const props = defineProps({
    formData: {
        type: Object,
        default: {
            plan_razon_social: "",
            plan_ruc: "",
            plan_marca: "",
            plan_tipo_planta: "A",
            plan_registro_sanitario: true,
            plan_marca_registrada: true,
            plan_barrio_comunidad: "",
            plan_sector: "",
            plan_latitud: null,
            plan_longitud: null,
            plan_tecnificacion: true,
            plan_parametros_digesa: true,
            plan_parametros_produccion: true,
            plan_capacitacion_tdd: true,
            plan_tcomp_id: null,
            plan_ubig_id: null,
            plan_ncap_id: null,
            plan_cpro_id: null,
            plan_inst_id: null,
        },
    },
    edit: {
        type: Boolean,
        default: false,
    },
    url: String,
});

const latlng =  props.formData.plan_latitud && props.formData.plan_longitud ? [ props.formData.plan_latitud, props.formData.plan_longitud] : [-15.284185114076433, -70.04000478753159];

onMounted(() => {
    const map = L.map("mapContainer").setView(latlng, 7);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "© OpenStreetMap contributors",
    }).addTo(map);

    const marker = L.marker(latlng).addTo(map);

    map.on("click", (event) => {
        const { lat, lng } = event.latlng;
        marker.setLatLng([lat, lng]);
        form.plan_latitud = lat;
        form.plan_longitud = lng;
    });
});

const form = useForm({ ...props.formData });

const formStructure = [
    {
        key: "plan_razon_social",
        label: "Razon social",
        type: "text",
        required: true,
        cols: 12,
        colMd: 7,
    },
    {
        key: "plan_ruc",
        label: "RUC",
        type: "text",
        required: true,
        cols: 12,
        colMd: 5,
    },
    {
        key: "plan_marca",
        label: "Marca",
        type: "text",
        required: false,
        cols: 12,
        colMd: 10,
    },
    {
        key: "plan_tipo_planta",
        label: "Tipo de planta",
        type: "select",
        options: ["A", "B", "C"],
        required: true,
        cols: 12,
        colMd: 2,
    },
    {
        key: "plan_barrio_comunidad",
        label: "Barrio o comunidad",
        type: "text",
        required: false,
        cols: 12,
        colMd: 6,
    },
    {
        key: "plan_sector",
        label: "Sector",
        type: "text",
        required: false,
        cols: 12,
        colMd: 6,
    },

    {
        key: "plan_latitud",
        label: "Latitud",
        type: "text",
        required: false,
        cols: 12,
        colMd: 3,
    },
    {
        key: "plan_longitud",
        label: "Longitud",
        type: "text",
        required: false,
        cols: 12,
        colMd: 3,
    },

    {
        key: "plan_ubig_id",
        label: "Ubicación geográfica",
        url: "/autocomplete/ubigeos",
        type: "autocomplete",
        itemTitle: "ubig_completo",
        itemValue: "ubig_id",
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "plan_tcomp_id",
        label: "Tipo de compañía",
        required: true,
        type: "autocomplete",
        url: "/autocomplete/tipo-companias",
        itemTitle: "tcomp_nombre",
        itemValue: "tcomp_id",
        cols: 12,
        colMd: 6,
    },

    {
        key: "plan_inst_id",
        label: "Institución",
        type: "autocomplete",
        url: "/autocomplete/tipo-instituciones",
        itemTitle: "inst_nombre",
        itemValue: "inst_id",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "plan_ncap_id",
        label: "Nivel de capacitación",
        type: "autocomplete",
        url: "/autocomplete/nivel-capacitaciones",
        itemTitle: "ncap_nombre",
        itemValue: "ncap_id",
        required: true,
        cols: 12,
        colMd: 6,
    },
    {
        key: "plan_cpro_id",
        label: "Calidad de productos",
        type: "autocomplete",
        url: "/autocomplete/calidad-productos",
        itemTitle: "cpro_nombre",
        itemValue: "cpro_id",
        required: true,
        cols: 12,
        colMd: 6,
    },

    {
        key: "plan_registro_sanitario",
        label: "Registro sanitario",
        type: "checkbox",
        required: false,
        cols: 6,
    },
    {
        key: "plan_marca_registrada",
        label: "Marca registrada",
        type: "checkbox",
        required: false,
        cols: 6,
    },
    {
        key: "plan_tecnificacion",
        label: "Tecnificación",
        type: "checkbox",
        required: false,
        cols: 6,
    },
    {
        key: "plan_parametros_digesa",
        label: "Parámetros DIGESA",
        type: "checkbox",
        required: false,
        cols: 6,
    },
    {
        key: "plan_parametros_produccion",
        label: "Parámetros de producción",
        type: "checkbox",
        required: false,
        cols: 6,
    },
    {
        key: "plan_capacitacion_tdd",
        label: "Capacitación TDD",
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
