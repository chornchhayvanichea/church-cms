<template>
  <div class="p-5 space-y-5">
    <div class="flex items-center gap-2">
      <div class="mr-auto flex gap-2">
        <UploadMedia :collection="MediaCollection.video" />
      </div>
    </div>
    <div
      class="grid gap-5"
      style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))"
    >
      <div v-for="video in videos" :key="video.id" class="relative group">
        <ClientOnly>
          <VideoPlayer :item="video" />
        </ClientOnly>

        <div
          class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex gap-2"
        >
          <UButton
            icon="i-heroicons-trash"
            color="primary"
            variant="ghost"
            size="sm"
          />
        </div>
      </div>
    </div>
    <UPagination
      v-model:page="page"
      :total="mediaStore.meta.total"
      :items-per-page="mediaStore.meta.per_page"
      class="flex justify-center mt-8"
    />
  </div>
</template>

<script setup lang="ts">
import { MediaCollection } from "~/types/mediaTypes";
import UploadMedia from "./UploadMedia.vue";
import VideoPlayer from "./VideoPlayer.vue";

const mediaStore = useMediaStore();
const { videos } = storeToRefs(mediaStore);

onMounted(async () => {
  await mediaStore.getMedia(page.value, "video");
});

const page = ref(1);
watch(page, async (newPage) => {
  await mediaStore.getMedia(newPage, "video");
});
</script>

<style scoped></style>
