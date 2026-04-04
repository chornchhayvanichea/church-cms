<template>
  <div class="space-y-4">
    <div class="grid grid-cols-2 gap-4">
      <UFormField label="Title" class="col-span-1">
        <UInput
          v-model="formData.title"
          placeholder="Enter blog title"
          class="w-full"
        />
      </UFormField>

      <UFormField label="Publish Date" class="col-span-1">
        <UInput
          v-model="formData.published_at"
          type="datetime-local"
          class="w-full"
        />
      </UFormField>
      <UFormField label="Status">
        <USelect
          v-model="formData.status"
          value-key="value"
          :items="blogStatus"
        />
      </UFormField>
    </div>

    <UFormField label="Excerpt">
      <UTextarea
        v-model="formData.excerpt"
        placeholder="Short summary..."
        :rows="3"
        class="w-full"
      />
    </UFormField>

    <UFormField>
      <MediaImagePicker v-model="formData.thumbnail" mime-type="image" />
    </UFormField>
  </div>
</template>

<script setup lang="ts">
import { BlogStatus, type BlogStoreData } from "~/types/blogTypes";
import MediaImagePicker from "../MediaImagePicker.vue";

const formData = defineModel<BlogStoreData>({
  default: () => ({
    title: "",
    excerpt: "",
    published_at: "",
    thumbnail: undefined,
    status: BlogStatus.draft,
  }),
});
const blogStatus = [
  { label: "Draft", value: BlogStatus.draft },
  { label: "Published", value: BlogStatus.published },
  { label: "Archived", value: BlogStatus.archived },
];
</script>
