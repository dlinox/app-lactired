<template>
    <AdminLayout>
        <v-card class="mb-4" variant="tonal">
            <v-card-item style="height: 700px">
                <div id="mapContainer" style="height: 700px"></div>
            </v-card-item>
        </v-card>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/layouts/AdminLayout.vue";
import { onMounted } from "vue";

const props = defineProps({
    plantas: Array,
});

const latlng = [-15.284185114076433, -70.04000478753159];

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

    console.log(props.plantas);

    props.plantas.forEach((element) => {
        if (element.plan_latitud != null && element.plan_longitud != null) {
            let marker = L.marker([
                element.plan_latitud,
                element.plan_longitud,
            ]).addTo(map);

            marker.bindPopup(element.plan_razon_social);
            marker.setIcon(iconoPersonalizado);
        }
    });
});
</script>
