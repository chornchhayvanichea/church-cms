<script setup lang="ts">
import DashboardSidebar from "~/components/dashboard/DashboardSidebar.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";
const authStore = useAuthStore();
</script>

<template>
  <UDashboardGroup>
    <DashboardSidebar />

    <UDashboardPanel>
      <UDashboardNavbar>
        <template #leading>
          <UDashboardSidebarCollapse />
        </template>

        <template #trailing>
          <UDashboardSearchButton collapsed :kbds="[]" variant="ghost" />
        </template>

        <template #right>
          <UColorModeSelect />
          <UUser
            :name="authStore.user?.name"
            :description="authStore.user?.role"
            :to="DASHBOARD_ROUTES.SETTINGS.PROFILE"
            :avatar="{
              src:
                authStore.user?.image ??
                'https://www.gravatar.com/avatar/?d=mp',
            }"
            :chip="{
              color: 'primary',
              position: 'top-right',
            }"
            class="mx-5"
          />
        </template>
      </UDashboardNavbar>
      <UScrollArea>
        <div class="p-4 min-h-svh">
          <slot />
        </div>
      </UScrollArea>
    </UDashboardPanel>
  </UDashboardGroup>
</template>
