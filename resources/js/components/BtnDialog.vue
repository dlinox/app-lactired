<template>
    <slot name="activator" :dialog="() => (dialog = !dialog)"></slot>
    <v-dialog v-model="dialog" :width="width" persistent>
        <v-card>
            <v-toolbar density="compact">
                <v-toolbar-title>  <small>{{title}} </small> </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon="mdi-close" color="dark" @click="dialog = false" />
            </v-toolbar>
            <v-container>
                <slot name="content" :dialog="() => (dialog = !dialog)"> </slot>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
    title: {
        type: String,
        default: "Nuevo usuario",
    },
    width: {
        type: String,
        default: "70vw",
    },
});

const dialog = ref(false);
</script>
