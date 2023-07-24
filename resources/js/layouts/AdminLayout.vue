<template>
    <v-app id="inspire">
        <v-navigation-drawer
            class="app-navigation-drawer"
            v-model="drawer"
            theme="dark"
            border="0"
            :width="260"
        >
            <v-card class="d-flex justify-center py-4" variant="tonal">
                <img
                    src="/images/logo-white.svg"
                    alt="Logo Lactired"
                    width="100"
                />
            </v-card>
            <MainMenu
                :items="user.menu"
                @onSubMenu="
                    ($event) => {
                        subMenu = $event;
                        subDrawer = true;
                    }
                "
            />

            <template v-slot:append>
                <v-list variant="tonal">
                    <v-list-item>
                        <template v-slot:append>
                            <v-tooltip text="Salir">
                                <template v-slot:activator="{ props }">
                                    <v-btn
                                        v-bind="props"
                                        color="red"
                                        icon
                                        rounded="lg"
                                        variant="tonal"
                                        size="small"
                                        @click="router.delete('/sign-out')"
                                    >
                                        <v-icon>mdi-logout</v-icon>
                                    </v-btn>
                                </template>
                            </v-tooltip>
                        </template>
                        <v-list-item-subtitle>
                            {{ user?.rol_name }}
                        </v-list-item-subtitle>
                        <v-list-item-title>
                            {{ user?.name }}
                        </v-list-item-title>

                        <v-tooltip :text="user?.user_plan_nombre">
                            <template v-slot:activator="{ props }">
                                <v-list-item-subtitle v-bind="props">
                                    <small>
                                        {{ user?.user_plan_nombre }}
                                    </small>
                                </v-list-item-subtitle>
                            </template>
                        </v-tooltip>
                    </v-list-item>
                </v-list>
            </template>
        </v-navigation-drawer>

        <v-app-bar absolute elevation="0">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-spacer></v-spacer>
            <SwitchTheme />

            <MenuProfile />
        </v-app-bar>

        <v-main>
            <!-- <v-navigation-drawer  v-model="subDrawer">
                <v-list nav>
                    <v-list-item
                        density="compact"
                        v-for="item in subMenu"
                        :title="item.title"
                        color="primary"
                        prepend-icon="mdi-circle-medium"
                        :value="item.value"
                        :class="
                            router.page.url == item.to
                                ? 'v-list-item--active text-primary'
                                : ''
                        "
                        @click="router.get(item.to)"
                    />
                </v-list>
            </v-navigation-drawer> -->
            <slot />
        </v-main>

        <v-snackbar v-model="snackbar" multi-line color="success">
            {{ flash.success }}

            <template v-slot:actions>
                <v-btn
                    color="dark"
                    variant="text"
                    @click="snackbar = false"
                    icon="mdi-close"
                ></v-btn>
            </template>
        </v-snackbar>

        <v-snackbar v-model="snackbarError" vertical multi-line color="error">
            <v-expansion-panels>
                <v-expansion-panel
                    elevation="0"
                    class="bg-transparent w-100"
                    :text="error.details"
                >
                    <v-expansion-panel-title
                        expand-icon="mdi-plus"
                        collapse-icon="mdi-minus"
                    >
                        {{ error.error }}
                    </v-expansion-panel-title>
                </v-expansion-panel>
            </v-expansion-panels>

            <template v-slot:actions>
                <v-btn
                    class="px-3"
                    color="white"
                    variant="tonal"
                    @click="snackbarError = false"
                    prepend-icon="mdi-close"
                >
                    Cerrar
                </v-btn>
            </template>
        </v-snackbar>
    </v-app>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";

import MainMenu from "../components/MainMenu.vue";
import SwitchTheme from "../components/SwitchTheme.vue";
import { useTheme } from "vuetify";
import MenuProfile from "../components/MenuProfile.vue";

const theme = useTheme();

const flash = computed(() => usePage().props?.flash);
const error = computed(() => usePage().props?.errors);

const user = computed(() => usePage().props?.auth?.user);

const drawer = ref(null);
const subDrawer = ref(false);
const subMenu = ref(null);

const snackbar = ref(false);
const snackbarError = ref(false);

watch(
    () => flash.value,
    (newValue) => {
        if (newValue && newValue.success) {
            snackbar.value = true;
        } else {
            snackbar.value = false;
        }
    }
);

watch(
    () => error.value,
    (newValue) => {
        if (newValue.details && newValue.error) {
            snackbarError.value = true;
        } else {
            snackbarError.value = false;
        }
    }
);

const items = [
    { title: "Click Me" },
    { title: "Click Me" },
    { title: "Click Me" },
    { title: "Click Me 2" },
];
</script>

<style lang="scss">
/* @import url('https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500&display=swap'); */
@import url("https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700;800;900&display=swap");
#inspire {
    /* font-family: 'Urbanist', sans-serif; */
    font-family: "Maven Pro", sans-serif;

    .v-navigation-drawer {
        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: rgba($color: #000000, $alpha: 0.2);
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: rgba($color: #aaa, $alpha: 0.3);
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    }
}
</style>
