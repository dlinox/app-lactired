<template>
    <v-menu>
        <template v-slot:activator="{ props }">
            <v-btn
                density="comfortable"
                rounded="lg"
                variant="tonal"
                v-bind="props"
                icon
            >
                <v-icon> mdi-account </v-icon>
            </v-btn>
        </template>
        <v-list nav min-width="130px">
            <!-- <v-list-item value="perfil" density="compact">
                <template v-slot:prepend class="me-1">
                    <v-icon icon="mdi-account-box"></v-icon>
                </template>
                <v-list-item-title> Perfil </v-list-item-title>
            </v-list-item> -->

            <v-list-item
                value="planta"
                density="compact"
                @click="()=> router.get('/plantas/show/1')"
            >
                <template v-slot:prepend>
                    <v-icon icon="mdi-domain"></v-icon>
                </template>
                <v-list-item-title> Mi planta </v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>
</template>
<script setup>
import { Link, router } from "@inertiajs/vue3";
</script>

<style>
.v-list-item__prepend .v-icon {
    margin-right: 10px !important;
}
</style>
