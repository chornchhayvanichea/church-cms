<template>
  <div>
    <LoginComponent />
  </div>
</template>

<script setup lang="ts">
import LoginComponent from "~/components/auth/LoginComponent.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";

const authStore = useAuthStore();

onMounted(async () => {
  await authStore.getUser();
  if (authStore.user) {
    navigateTo(DASHBOARD_ROUTES.ROOT);
  }
});
definePageMeta({
  layout: "auth",
});
</script>

<style scoped></style>
