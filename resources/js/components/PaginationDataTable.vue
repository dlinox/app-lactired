<template>
    <small class="me-3">
        {{ items.from }} - {{ items.to }} de {{ items.total }}
    </small>

    <span class="text-grey-lighten-2">|</span>

    <v-btn
        color="black"
        rounded="lg"
        density="comfortable"
        variant="text"
        icon="mdi-page-first"
        :disabled="items.current_page == 1"
        @click="router.get(items.first_page_url)"
    >
    </v-btn>

    <v-btn
        color="black"
        rounded="lg"
        density="comfortable"
        variant="text"
        icon="mdi-chevron-left"
        :disabled="!items.prev_page_url"
        @click="router.get(items.prev_page_url)"
    >
    </v-btn>

    <v-btn
        color="black"
        rounded="lg"
        density="comfortable"
        variant="text"
        icon="mdi-chevron-left"
    >
        <small>
            {{ items.current_page }}
        </small>
    </v-btn>
    <v-btn
        color="black"
        rounded="lg"
        density="comfortable"
        variant="text"
        icon="mdi-chevron-right"
        :disabled="!items.next_page_url"
        @click="router.get(items.next_page_url)"
    >
    </v-btn>

    <v-btn
        color="black"
        rounded="lg"
        density="comfortable"
        variant="text"
        icon="mdi-page-last"
        :disabled="items.current_page == items.last_page"
        @click="router.get(items.last_page_url)"
    >
    </v-btn>
</template>

<script setup>
import { router } from "@inertiajs/vue3";

const props = defineProps({
    items: Object,
});
</script>
