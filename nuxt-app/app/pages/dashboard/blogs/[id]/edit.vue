<template>
  <div>this is edit blog blog id: {{ id }}</div>
</template>

<script setup lang="ts">
const route = useRoute();
const id = route.params.id;
definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});
</script>

<style scoped></style>
