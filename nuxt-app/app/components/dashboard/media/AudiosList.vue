<template>
  <div class="space-y-5 p-5">
    <div class="flex justify-between items-center mb-4">
      <UploadMedia :collection="MediaCollection.audio" />
    </div>

    <div v-if="!audios.length" class="text-center py-12 text-gray-400 text-sm">
      No audio files yet
    </div>

    <div v-else class="flex flex-col gap-2">
      <div
        v-for="audio in audios"
        :key="audio.id"
        class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900"
      >
        <UButton
          :icon="
            isTrackPlaying(audio.id) ? 'i-heroicons-pause' : 'i-heroicons-play'
          "
          size="sm"
          color="neutral"
          variant="ghost"
          @click="
            onPlayAsPlaylist(
              tracks,
              tracks.find((t) => t.id === audio.id),
            )
          "
        />

        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium truncate">{{ audio.name }}</p>
          <p class="text-xs text-gray-400">{{ audio.mime_type }}</p>
        </div>

        <span class="text-xs text-gray-400 min-w-12 text-right">
          {{ formatSize(audio.size) }}
        </span>

        <UButton
          icon="i-heroicons-trash"
          size="sm"
          color="error"
          variant="ghost"
          @click="deleteAudio(audio.id)"
        />
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
import type { TMusicFlow } from "vue-music-flow";
import UploadMedia from "./UploadMedia.vue";

const page = ref(1);

const mediaStore = useMediaStore();

const { audios } = storeToRefs(mediaStore);
onMounted(async () => {
  await mediaStore.getMedia(page.value, "audio");
});
watch(page, async (newPage) => {
  await mediaStore.getMedia(newPage, "audio");
});

const deleteAudio = async (id: number) => {
  await mediaStore.removeMedia(id);
};
const { onPlayAsPlaylist, isTrackPlaying } = useMusicFlow();

const tracks = computed<TMusicFlow[]>(() =>
  mediaStore.audios.map((audio) => ({
    id: audio.id,
    audio: audio.original_url,
    title: audio.name,
    artist: "",
    artwork: "",
    album: "",
    original: audio as unknown as Record<string, unknown>,
  })),
);
const formatSize = (bytes: number) => {
  const mb = bytes / (1024 * 1024);
  return mb >= 1 ? `${mb.toFixed(1)} MB` : `${(bytes / 1024).toFixed(0)} KB`;
};
definePageMeta({
  layout: "dashboard",
});
</script>
