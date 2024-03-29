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
        <template #field.plan_imagen>
            <v-card variant="tonal">
                <CropCompressImage
                    :aspect-ratio="16 / 9"
                    @onCropper="
                        (preview_img = $event.blob),
                            (form.plan_imagen = $event.file)
                    "
                />

                <v-img
                    v-if="preview_img"
                    class="mx-auto"
                    :width="350"
                    aspect-ratio="16/9"
                    cover
                    :src="preview_img"
                ></v-img>

                <v-img
                    v-if="form.plan_imagen_url && !preview_img"
                    class="mx-auto"
                    :width="300"
                    aspect-ratio="16/9"
                    cover
                    :src="form.plan_imagen_url"
                ></v-img>
            </v-card>
        </template>
    </SimpleForm>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import L from "leaflet";
import SimpleForm from "@/components/SimpleForm.vue";
import CropCompressImage from "@/components/CropCompressImage.vue";

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

const latlng =
    props.formData.plan_latitud && props.formData.plan_longitud
        ? [props.formData.plan_latitud, props.formData.plan_longitud]
        : [-15.284185114076433, -70.04000478753159];

onMounted(() => {
    var iconoPersonalizado = L.icon({
        iconUrl: "/marker_red.png",
        iconSize: [30, 30], // Tamaño del ícono
        iconAnchor: [15, 15], // Punto de anclaje del ícono
    });

    const map = L.map("mapContainer").setView(latlng, 7);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "© OpenStreetMap contributors",
    }).addTo(map);

    const marker = L.marker(latlng).addTo(map);

    marker.setIcon(iconoPersonalizado);

    map.on("click", (event) => {
        const { lat, lng } = event.latlng;
        marker.setLatLng([lat, lng]);
        form.plan_latitud = lat;
        form.plan_longitud = lng;
    });
});

const form = useForm({ ...props.formData });

const preview_img = ref(null);

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
        readonly: true,
        cols: 12,
        colMd: 3,
    },
    {
        key: "plan_longitud",
        label: "Longitud",
        type: "text",
        required: false,
        readonly: true,
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
        itemsDefault: form.ubigeo,

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
        itemsDefault: form.tipo_compania,

        cols: 12,
        colMd: 6,
    },

    {
        key: "plan_inst_id",
        label: "Institución",
        type: "autocomplete",
        url: "/autocomplete/tipo-instituciones",
        itemTitle: "inst_nombre",
        itemsDefault: form.institucion,
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
        itemsDefault: form.nivel_capacitacion,
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
        itemsDefault: form.calidad_producto,
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

    {
        key: "plan_imagen",
        label: "Imagen",
        type: "textarea",
        required: false,
        cols: 12,
    },

    {
        key: "plan_descripcion",
        label: "Descripción",
        type: "textarea",
        required: false,
        cols: 12,
    },
];



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
</script>
