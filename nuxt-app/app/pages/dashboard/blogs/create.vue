<template>
  <div>
    <UDashboardToolbar
      class="sticky top-0 z-10 dark:bg-slate-900 light:bg-white"
    >
      <UNavigationMenu :items="items1" highlight class="flex-1" />
    </UDashboardToolbar>
    <UContainer class="rounded-2xl p-10">
      <BlogEditor v-if="activeTab === 'editor'" />
      <BlogGeneral v-if="activeTab === 'general'" />

      <div class="space-x-2 space-y-5">
        <UButton> save </UButton>
        <UButton variant="outline"> cancel </UButton>
      </div>
    </UContainer>
  </div>
</template>

<script setup lang="ts">
import type { NavigationMenuItem } from "@nuxt/ui";
import BlogEditor from "~/components/dashboard/editors/BlogEditor.vue";
import BlogGeneral from "~/components/dashboard/editors/BlogGeneral.vue";
const activeTab = ref("general");
const items1 = computed<NavigationMenuItem[][]>(() => [
  [
    {
      label: "General",
      icon: "i-lucide-users",
      active: activeTab.value === "general",
      onSelect: () => (activeTab.value = "general"),
    },
    {
      label: "Editor",
      icon: "i-lucide-user",
      active: activeTab.value === "editor",
      onSelect: () => (activeTab.value = "editor"),
    },
  ],
  [
    {
      label: "Help & Feedback",
      icon: "i-lucide-help-circle",
      to: "https://github.com/nuxt/ui/issues",
      target: "_blank",
    },
  ],
]);

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});
</script>
