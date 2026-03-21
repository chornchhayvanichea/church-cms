<template>
  <div>
    <UploadMedia :collection="MediaCollection.audio" />
  </div>
</template>

<script setup lang="ts">
import { MediaCollection } from "~/types/mediaTypes";
import UploadMedia from "./UploadMedia.vue";
</script>

<style scoped></style>
