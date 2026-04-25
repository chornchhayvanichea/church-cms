<script setup lang="ts">
import DashboardSidebar from "~/components/dashboard/DashboardSidebar.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";

const authStore = useAuthStore();

const searchGroups = computed(() => [
  {
    id: "pages",
    label: "Navigate",
    items: [
      { label: "Dashboard", icon: "i-lucide-house", to: DASHBOARD_ROUTES.ROOT },
      { label: "Blogs", icon: "i-lucide-book", to: DASHBOARD_ROUTES.BLOGS },
      { label: "New Blog", icon: "i-lucide-plus", suffix: "Blog", to: DASHBOARD_ROUTES.BLOGS_CREATE },
      { label: "Sermons", icon: "i-lucide-mic", to: DASHBOARD_ROUTES.SERMONS },
      { label: "New Sermon", icon: "i-lucide-plus", suffix: "Sermon", to: DASHBOARD_ROUTES.SERMONS_CREATE },
      { label: "Events", icon: "i-lucide-calendar-days", to: DASHBOARD_ROUTES.EVENTS },
      { label: "New Event", icon: "i-lucide-plus", suffix: "Event", to: DASHBOARD_ROUTES.EVENTS_CREATE },
      { label: "Series", icon: "i-lucide-layers", to: DASHBOARD_ROUTES.SERIES },
      { label: "New Series", icon: "i-lucide-plus", suffix: "Series", to: DASHBOARD_ROUTES.SERIES_CREATE },
      { label: "Media", icon: "i-heroicons-film", to: DASHBOARD_ROUTES.MEDIA },
      ...(authStore.isAdmin
        ? [{ label: "Users", icon: "i-lucide-users", to: DASHBOARD_ROUTES.USERS }]
        : []),
      ...(authStore.isAdmin
        ? [{ label: "Site Settings", icon: "i-lucide-settings", to: DASHBOARD_ROUTES.SETTINGS.SITE }]
        : []),
      { label: "My Profile", icon: "i-lucide-user", to: DASHBOARD_ROUTES.SETTINGS.PROFILE },
    ],
  },
]);
</script>

<template>
  <UDashboardGroup>
    <DashboardSidebar />
    <UDashboardPanel>
      <UDashboardSearch :groups="searchGroups" />
      <MusicFlow :options="{ autoplay: true }" />
      <UDashboardNavbar>
        <template #leading> <UDashboardSidebarCollapse /> </template>

        <template #trailing>
          <UDashboardSearchButton collapsed :kbds="['meta', 'K']" variant="ghost" />
        </template>

        <template #right>
          <UColorModeSelect />
          <UUser
            :name="authStore.user?.name"
            :description="authStore.user?.role"
            :to="DASHBOARD_ROUTES.SETTINGS.PROFILE"
            :avatar="{
              src:
                authStore.user?.avatar ??
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
