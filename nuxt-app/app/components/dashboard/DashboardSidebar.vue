<script setup lang="ts">
import type { NavigationMenuItem } from "@nuxt/ui";

const items: NavigationMenuItem[][] = [
  [
    {
      label: "Home",
      icon: "i-lucide-house",
      to: "/dashboard/",
    },
    {
      label: "Announcements",
      icon: "i-lucide-megaphone", // broadcast message
      to: "/dashboard/announcements",
    },
    {
      label: "Categories",
      icon: "i-lucide-tags", // tagging / classification
      to: "/dashboard/categories",
    },
    {
      label: "Events",
      icon: "i-lucide-calendar-days", // schedule / dates
      to: "/dashboard/events",
    },
    {
      label: "Sermons",
      icon: "i-lucide-mic", // preaching / speaking
      //    badge: "4",
      to: "/dashboard/sermons",
    },
    {
      label: "Pages",
      icon: "i-lucide-note",
      to: "/dashboard/pages",
    },
    {
      label: "Series",
      icon: "i-lucide-layers", // grouped content / collection
      to: "/dashboard/series",
    },
    {
      label: "Users",
      icon: "i-lucide-users", // people
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
