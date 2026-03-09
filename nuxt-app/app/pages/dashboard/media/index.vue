<template>
  <div class="p-5">
    <div class="text-4xl font-bold">Media Library</div>

    <UDashboardToolbar
      class="sticky top-0 z-10 dark:bg-slate-900 light:bg-white"
    >
      <UNavigationMenu :items="mediaTab" highlight class="flex-1" />
    </UDashboardToolbar>
    <RecentMediaList v-show="activeTab === 'recents'" />
    <AudiosList v-show="activeTab === 'audios'" />
    <ImagesList v-show="activeTab === 'images'" />
    <VideosList v-show="activeTab === 'videos'" />
    <UPagination
      v-model:page="page"
      :total="mediaStore.meta.total"
      :items-per-page="mediaStore.meta.per_page"
    />
  </div>
</template>

<script setup lang="ts">
import type { NavigationMenuItem } from "@nuxt/ui";
import AudiosList from "~/components/dashboard/media/AudiosList.vue";
import ImagesList from "~/components/dashboard/media/ImagesList.vue";
import RecentMediaList from "~/components/dashboard/media/RecentMediaList.vue";
import VideosList from "~/components/dashboard/media/VideosList.vue";

const activeTab = useState("mediaTab", () => "recents");

const page = ref(1);
watch(page, async (newPage) => {
  await mediaStore.getMedia(newPage);
});

const mediaStore = useMediaStore();
onMounted(async () => {
  await mediaStore.getMedia();
});
const mediaTab = computed<NavigationMenuItem[][]>(() => [
  [
    {
      label: "Recents",
      //     icon: "i-lucide-users",
      active: activeTab.value === "recents",
      onSelect: () => (activeTab.value = "recents"),
    },
  ],
  [
    {
      label: "Images",
      //    icon: "i-lucide-users",
      active: activeTab.value === "images",
      onSelect: () => (activeTab.value = "images"),
    },
    {
      label: "Audios",
      //      icon: "i-lucide-users",
      active: activeTab.value === "audios",
      onSelect: () => (activeTab.value = "audios"),
    },

    {
      label: "Videos",
      //     icon: "i-lucide-users",
      active: activeTab.value === "videos",
      onSelect: () => (activeTab.value = "videos"),
    },
  ],
]);

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});
</script>
