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

const items = computed<NavigationMenuItem[][]>(() => [
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
    ...(authStore.isAdmin
      ? [
          {
            label: "Users",
            icon: "i-lucide-users",
            to: DASHBOARD_ROUTES.USERS,
          },
        ]
      : []),
    {
      label: "Settings",
      icon: "i-lucide-settings",
      defaultOpen: true,
      children: [
        ...(authStore.isAdmin
          ? [{ label: "Site Settings", to: DASHBOARD_ROUTES.SETTINGS.SITE }]
          : []),
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
]);
</script>

<template>
  <UDashboardSidebar
    collapsible
    resizable
    :ui="{ footer: 'border-t border-default' }"
  >
    <template #header="{ collapsed }">
      <div v-if="!collapsed" class="flex items-center gap-2.5">
        <LogoComponent class="h-5 w-auto shrink-0" />
        <span
          class="text-sm font-semibold text-highlighted truncate"
          style="font-family: 'Cormorant Garamond', serif; letter-spacing: 0.01em;"
        >Grace Church</span>
      </div>
      <svg
        v-else
        class="size-5 mx-auto text-[#c9a96e]"
        viewBox="0 0 36 48"
        fill="none"
      >
        <rect x="13" y="0" width="10" height="48" rx="1.5" fill="currentColor" opacity="0.8" />
        <rect x="0" y="14" width="36" height="10" rx="1.5" fill="currentColor" opacity="0.8" />
      </svg>
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
        :items="items[0]!"
        orientation="vertical"
      />
    </template>
  </UDashboardSidebar>
</template>
