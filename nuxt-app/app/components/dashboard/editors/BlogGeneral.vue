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
    </div>

    <UFormField label="Excerpt">
      <UTextarea
        v-model="formData.excerpt"
        placeholder="Short summary..."
        :rows="3"
        class="w-full"
      />
    </UFormField>
    <UFormField label="Thumbnail">
      <UFileUpload
        v-model="formData.thumbnail"
        label="Drop your image here"
        description="SVG, PNG, JPG or GIF (max. 2MB)"
        class="w-96 min-h-48"
        accept="image/*"
      />
    </UFormField>
  </div>
</template>

<script setup lang="ts">
import type { BlogStoreData } from "~/types/blogTypes";

const formData = defineModel<BlogStoreData>({
  default: () => ({
    title: "",
    excerpt: "",
    published_at: "",
    thumbnail: undefined,
  }),
});
</script>
