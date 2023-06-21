<template>
    <AdminLayout>
        <HeadingPage title="Planta" subtitle="Crear nueva planta">
        </HeadingPage>

        <v-container fluid>
            <Formulario :url="url" />
        </v-container>
    </AdminLayout>
</template>
<script setup>
import { router } from "@inertiajs/vue3";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";

import Formulario from "./components/Formulario.vue";

const props = defineProps({
    items: Object,
    headers: Array,
    filters: Object,
    perPageOptions: Array,
});

const url = "/config/plantas";
const primaryKey = "plan_id";
</script>
