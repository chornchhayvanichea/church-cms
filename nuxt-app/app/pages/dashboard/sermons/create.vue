<template>
  <div>
    <UFormField label="title">
      <UInput v-model="formData.title" />
    </UFormField>
    <UFormField label="speaker">
      <UInput v-model="formData.speaker" />
    </UFormField>
    <UFormField label="sermon_date">
      <UInput v-model="formData.sermon_date" type="date" />
    </UFormField>
    <UFormField label="scripture_reference">
      <UInput v-model="formData.scripture_reference" />
    </UFormField>
    <UFormField label="thumbnail">
      <MediaImagePicker
        v-model="formData.thumbnail"
        accept="image/*"
        mime-type="image"
      />
    </UFormField>
    <UFormField label="audio">
      <MediaImagePicker
        v-model="formData.audio"
        accpet="audio/*"
        mime-type="audio"
      />
    </UFormField>

    <UFormField label="video">
      <MediaImagePicker
        v-model="formData.video"
        accpet="video/*"
        mime-type="video"
      />
    </UFormField>

    <UFormField label="published_at">
      <UInput v-model="formData.published_at" type="date" />
    </UFormField>
    <UFormField label="status">
      <UInput v-model="formData.status" />
    </UFormField>
    <UButton @click="submitHandler">submit</UButton>
  </div>
</template>

<script setup lang="ts">
import MediaImagePicker from "~/components/dashboard/MediaImagePicker.vue";
import { SermonStatus, type SermonStoreData } from "~/types/sermonTypes";

const sermonStore = useSermonStore();
const formData = ref<SermonStoreData>({
  title: "",
  speaker: "",
  sermon_date: "",
  description: "",
  notes: "",
  published_at: "",
  status: SermonStatus.draft,
});
const submitHandler = async () => {
  await sermonStore.createSermon(formData.value);
};
//  title: string;
//  speaker: string;
//  sermon_date: string;
//  description?: string;
//  notes?: string;
//  scripture_reference?: string;
//  video?: File | string;
//  audio?: File | string;
//  thumbnail?: File | string;
//  published_at?: string;
//  status?: SermonStatus;
//}
definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});
</script>

<style scoped></style>
