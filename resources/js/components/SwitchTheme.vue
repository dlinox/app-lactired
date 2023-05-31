<template>
  <VBtn @click="toggleTheme" :icon="themeIcon" size="small" rounded="xl">

  </VBtn>
</template>
<script setup>
import { computed } from "vue";
import { useTheme } from "vuetify";
const theme = useTheme();
const toggleTheme = () =>
  (theme.global.name.value = theme.global.current.value.dark
      ? "light"
      : "dark");
const themeIcon = computed(() =>
  theme.global.name.value == "light"
      ? "mdi-weather-night"
      : "mdi-white-balance-sunny"
);
</script>
