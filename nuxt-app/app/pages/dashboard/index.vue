<script setup lang="ts">
import VideoPlayer from "~/components/dashboard/media/VideoPlayer.vue";

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});
</script>
<template>
  <div>
    <ClientOnly>
      <VideoPlayer />
    </ClientOnly>
    this is home dashboard
  </div>
</template>
