<template>
    <v-card class="mb-4" variant="tonal">
        <v-card-item  :style="`height: ${height}px`">
            <div id="mapContainer" :style="`height: ${height}px`"></div>
        </v-card-item>
    </v-card>
</template>
<script setup>
import { onMounted } from "vue";
import L from "leaflet";

const props = defineProps({
    latitud: {
        type: [Number, String],
        default: -15.284185114076433,
    },
    longitud: {
        type: [Number, String],
        default: -70.04000478753159,
    },
    height: {
        type: [Number, String],
        default: 200,
    }
});

const latlng =
    props.latitud && props.longitud
        ? [props.latitud, props.longitud]
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

});
</script>
