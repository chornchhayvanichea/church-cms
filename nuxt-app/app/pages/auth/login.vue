<template>
  <div>
    <LoginComponent />
  </div>
</template>

<script setup lang="ts">
import LoginComponent from "~/components/auth/LoginComponent.vue";
definePageMeta({
  layout: "auth",
});
</script>

<style scoped></style>
