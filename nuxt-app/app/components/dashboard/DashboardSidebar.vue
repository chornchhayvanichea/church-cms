<script setup lang="ts">
import type { NavigationMenuItem } from "@nuxt/ui";
import { DASHBOARD_ROUTES } from "~/constants/routes";

const authStore = useAuthStore();
const handleLogout = async () => {
  await authStore.logout();
  if (authStore.user) {
    await navigateTo("/dashboard");
  }
};
const items: NavigationMenuItem[][] = [
  [
    {
      label: "Home",
      icon: "i-lucide-house",
      to: DASHBOARD_ROUTES.ROOT,
    },
    {
      label: "Events",
      icon: "i-lucide-calendar-days",
      to: DASHBOARD_ROUTES.EVENTS,
    },
    {
      label: "Sermons",
      icon: "i-lucide-mic",
      to: DASHBOARD_ROUTES.SERMONS,
    },
    {
      label: "Blogs",
      icon: "i-lucide-book",
      to: DASHBOARD_ROUTES.BLOGS,
    },

    {
      label: "Media",
      icon: "i-heroicons-film",
      to: DASHBOARD_ROUTES.MEDIA,
    },
    {
      label: "Series",
      icon: "i-lucide-layers",

      to: DASHBOARD_ROUTES.SERIES,
    },
    {
      label: "Users",
      icon: "i-lucide-users",
      to: DASHBOARD_ROUTES.USERS,
    },
    {
      label: "Settings",
      icon: "i-lucide-settings",
      defaultOpen: true,
      children: [
        {
          label: "Homepage settings",
        },
        {
          label: "Aboutpage settings",
        },
        {
          label: "User Profile",
          to: DASHBOARD_ROUTES.SETTINGS.PROFILE,
        },
      ],
    },
    {
      label: "Logout",
      icon: "i-lucide-log-out",
      onSelect: handleLogout,
    },
  ],
];
</script>

<template>
  <UDashboardSidebar
    collapsible
    resizable
    :ui="{ footer: 'border-t border-default' }"
  >
    <template #header="{ collapsed }">
      <LogoComponent v-if="!collapsed" class="h-5 w-auto shrink-0" />
      <UIcon
        v-else
        name="i-simple-icons-nuxtdotjs"
        class="size-5 text-primary mx-auto"
      />
    </template>

    <template #default="{ collapsed }">
      <!--
      <UButton
        :label="collapsed ? undefined : 'Search...'"
        icon="i-lucide-search"
        color="neutral"
        variant="outline"
        block
        :square="collapsed"
      >
        <template v-if="!collapsed" #trailing>
          <div class="flex items-center gap-0.5 ms-auto">
            <UKbd value="meta" variant="subtle" />
            <UKbd value="K" variant="subtle" />
          </div>
        </template>
      </UButton>
      -->
      <UNavigationMenu
        :collapsed="collapsed"
        :items="items[0]"
        orientation="vertical"
      />
    </template>
  </UDashboardSidebar>
</template>
