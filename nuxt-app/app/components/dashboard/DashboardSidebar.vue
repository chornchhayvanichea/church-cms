<script setup lang="ts">
import type { NavigationMenuItem } from "@nuxt/ui";

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
      to: "/dashboard/",
    },
    {
      label: "Events",
      icon: "i-lucide-calendar-days",
      to: "/dashboard/events",
    },
    {
      label: "Sermons",
      icon: "i-lucide-mic",
      //    badge: "4",
      to: "/dashboard/sermons",
    },
    {
      label: "Blogs",
      icon: "i-lucide-book",
      to: "/dashboard/sermons",
    },

    {
      label: "Series",
      icon: "i-lucide-layers",
      to: "/dashboard/series",
    },
    {
      label: "Users",
      icon: "i-lucide-users",
      to: "/dashboard/users",
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
      ],
    },
    {
      label: "Logout",
      icon: "i-lucide-button",
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
      <Logo v-if="!collapsed" class="h-5 w-auto shrink-0" />
      <UIcon
        v-else
        name="i-simple-icons-nuxtdotjs"
        class="size-5 text-primary mx-auto"
      />
    </template>

    <template #default="{ collapsed }">
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

      <UNavigationMenu
        :collapsed="collapsed"
        :items="items[0]"
        orientation="vertical"
      />

      <UNavigationMenu
        :collapsed="collapsed"
        :items="items[1]"
        orientation="vertical"
        class="mt-auto"
      />
    </template>

    <template #footer="{ collapsed }">
      <UButton
        :avatar="{
          src: 'https://github.com/benjamincanac.png',
        }"
        :label="collapsed ? undefined : 'Benjamin'"
        color="neutral"
        variant="ghost"
        class="w-full"
        :block="collapsed"
      />
    </template>
  </UDashboardSidebar>
</template>
