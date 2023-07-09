<template>
  <div>
    <h1>Error 403 - Acceso Denegado</h1>
    <p>{{ message }}</p>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      default: 'No tienes permiso para acceder a esta página.',
    },
  },
};
</script>