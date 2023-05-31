<template>
    <v-img
        :width="LogoWidth"
        aspect-ratio="16/9"
        :src="
            LogoTheme == 'auto'
                ? logo
                : LogoTheme == 'light'
                ? '/images/logo.svg'
                : '/images/logo-white.svg'
        "
    ></v-img>
</template>
<script setup>
import { computed } from "vue";
import { useTheme } from "vuetify";

const props = defineProps({
    LogoTheme: {
        type: String,
        default: "auto",
    },

    LogoWidth: {
        type: Number,
        default: 100,
    },
});

const theme = useTheme();

const logo = computed(() =>
    theme.global.name.value == "light"
        ? "/images/logo.svg"
        : "/images/logo-white.svg"
);
</script>
