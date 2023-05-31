<template>
    <v-app id="inspire">
        <v-navigation-drawer
            class="app-navigation-drawer"
            v-model="drawer"
            theme="dark"
            border="0"
            :width="260"
        >
            <!-- <v-card class="ma-2 text-secondary" variant="tonal">              
                <Logo class="py-5 mx-auto" LogoTheme="dark" :LogoWidth="100"></Logo>
            </v-card> -->
            <MainMenu />
        </v-navigation-drawer>

        <v-app-bar absolute elevation="0">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title> <Logo></Logo> </v-toolbar-title>
            <v-spacer></v-spacer>
            <SwitchTheme />
            <v-btn
                color="red"
                icon
                size="small"
                @click="router.delete('/logout')"
            >
                <v-icon>mdi-logout</v-icon>
            </v-btn>
        </v-app-bar>

        <v-main>
            <slot />
        </v-main>
    </v-app>
</template>

<script setup>
import { ref } from "vue";
import MainMenu from "../components/MainMenu.vue";
import SwitchTheme from "../components/SwitchTheme.vue";
import Logo from "../components/Logo.vue";
import { router, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
const drawer = ref(null);
const user = computed(() => usePage().props?.auth?.user);
</script>

<style lang="scss">
/* @import url('https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500&display=swap'); */
@import url("https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700;800;900&display=swap");
#inspire {
    /* font-family: 'Urbanist', sans-serif; */
    font-family: "Maven Pro", sans-serif;

    .v-navigation-drawer.app-navigation-drawer {
        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: rgba($color: #000000, $alpha: .4);
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: rgba($color: #DDD, $alpha: .3);
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    }
}
</style>
