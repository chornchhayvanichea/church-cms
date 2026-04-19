<script setup lang="ts">
import type { NavigationMenuItem } from "@nuxt/ui";
import AudiosList from "~/components/dashboard/media/AudiosList.vue";
import ImagesList from "~/components/dashboard/media/ImagesList.vue";
import VideosList from "~/components/dashboard/media/VideosList.vue";

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});

const activeTab = useState("mediaTab", () => "images");

const mediaTabs = computed<NavigationMenuItem[][]>(() => [
  [
    {
      label: "Images",
      icon: "i-lucide-image",
      active: activeTab.value === "images",
      onSelect: () => (activeTab.value = "images"),
    },
    {
      label: "Audio",
      icon: "i-lucide-music",
      active: activeTab.value === "audios",
      onSelect: () => (activeTab.value = "audios"),
    },
    {
      label: "Videos",
      icon: "i-lucide-video",
      active: activeTab.value === "videos",
      onSelect: () => (activeTab.value = "videos"),
    },
  ],
]);
</script>

<template>
  <div class="px-6 py-8 space-y-6">
    <div>
      <p class="text-sm text-muted mb-1">Assets</p>
      <h1 class="text-2xl font-semibold text-highlighted">Media Library</h1>
    </div>

    <UDashboardToolbar class="sticky top-0 z-10">
      <UNavigationMenu :items="mediaTabs[0]!" highlight orientation="horizontal" />
    </UDashboardToolbar>

    <ImagesList v-if="activeTab === 'images'" />
    <AudiosList v-else-if="activeTab === 'audios'" />
    <VideosList v-else-if="activeTab === 'videos'" />
  </div>
</template>
