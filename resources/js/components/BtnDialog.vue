<template>
    <slot name="activator" :dialog="() => (dialog = !dialog)"></slot>
    <v-dialog
        :fullscreen="!display.smAndUp.value"
        scrollable
        v-model="dialog"
        height="auto"
        :width="display.smAndUp.value ? width : null"
    >
        <v-card>
            <v-card-title class="pa-0">
                <v-toolbar density="compact">
                    <v-toolbar-title>
                        <small>{{ title }} </small>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn
                        icon="mdi-close"
                        color="dark"
                        @click="dialog = false"
                    />
                </v-toolbar>
            </v-card-title>
            <v-card-text>
                <slot name="content" :dialog="() => (dialog = !dialog)"> </slot>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref } from "vue";
import { useDisplay } from "vuetify/lib/framework.mjs";

const display = useDisplay();

const props = defineProps({
    title: {
        type: String,
        default: "Nuevo usuario",
    },
    width: {
        type: String,
        default: "80vw",
    },
});

const dialog = ref(false);
</script>
