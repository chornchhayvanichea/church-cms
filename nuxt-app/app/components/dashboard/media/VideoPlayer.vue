<template>
  <div>
    <img
      v-if="props.item.preview_url"
      :src="props.item.preview_url"
      alt="video thumbnail"
      class="mb-2 rounded"
    />
    <video ref="player" controls>
      <source :src="props.item.original_url" type="video/mp4" />
    </video>
    <p class="mt-1 text-center font-medium">{{ props.item.name }}</p>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import Plyr from "plyr";
import "plyr/dist/plyr.css";
import type { Media } from "~/types/mediaTypes";

const props = defineProps<{ item: Media }>();

const player = ref<HTMLVideoElement | null>(null);

onMounted(() => {
  if (player.value) {
    new Plyr(player.value);
  }
});
</script>

<style scoped></style>
