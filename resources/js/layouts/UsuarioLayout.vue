<template>
    <v-app id="inspire">
        <v-app-bar flat>
            <v-container class="fill-height d-flex align-center">
                <v-avatar
                    class="me-10 ms-4"
                    color="grey-darken-1"
                    size="32"
                    icon="mdi-account"
                ></v-avatar>

                <v-btn variant="text"> Nombre y Apellidos </v-btn>

                <v-spacer></v-spacer>
                <SwitchTheme />

                <v-btn
                    color="red"
                    icon
                    size="small"
                    @click="router.delete('/u/logout')"
                >
                    <v-icon>mdi-logout</v-icon>
                </v-btn>
            </v-container>
        </v-app-bar>

        <v-main class="">
            <slot />
        </v-main>
    </v-app>
</template>

<script setup>
import SwitchTheme from "../components/SwitchTheme.vue";
import { router } from "@inertiajs/vue3";

</script>
