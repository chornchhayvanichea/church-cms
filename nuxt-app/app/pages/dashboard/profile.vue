<template>
  <div>
    {{ authStore.user?.id }}
    <br />
    {{ authStore.user?.image }}
    <br />
    {{ authStore.user?.name }}
    <br />
    {{ authStore.user?.email }}
    <br />
    {{ authStore.user?.role }}
    <br />
    {{ authStore.user?.created_at }}
    <br />
    {{ authStore.user?.updated_at }}
    <br />
    {{ authStore.user?.password }}
  </div>
</template>

<script setup lang="ts">
const authStore = useAuthStore();
definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});
</script>
