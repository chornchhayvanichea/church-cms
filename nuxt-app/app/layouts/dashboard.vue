<script setup lang="ts">
import DashboardSidebar from "~/components/dashboard/DashboardSidebar.vue";
</script>

<template>
  <UDashboardGroup>
    <UDashboardSidebarToggle variant="subtle" />
    <DashboardSidebar />
    <slot />
  </UDashboardGroup>
</template>
