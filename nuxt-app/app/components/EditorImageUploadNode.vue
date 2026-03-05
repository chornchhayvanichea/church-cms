<script setup lang="ts">
import { editorUploadImage } from "~/services/blogs";
import type { NodeViewProps } from "@tiptap/vue-3";
import { NodeViewWrapper } from "@tiptap/vue-3";

const props = defineProps<NodeViewProps>();

const file = ref<File | null>(null);
const loading = ref(false);

watch(file, async (newFile) => {
  if (!newFile) return;

  loading.value = true;

  try {
    const response = await editorUploadImage(newFile);

    console.log(response.data);
    const imageUrl = response.data.url;

    const pos = props.getPos();
    if (typeof pos !== "number") {
      loading.value = false;
      return;
    }
    props.editor
      .chain()
      .focus()
      .deleteRange({ from: pos, to: pos + 1 })
      .setImage({ src: imageUrl })
      .run();
  } catch (e) {
    console.error(e);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <NodeViewWrapper>
    <UFileUpload
      v-model="file"
      accept="image/*"
      label="Upload an image"
      description="SVG, PNG, JPG or GIF (max. 2MB)"
      :preview="false"
      class="min-h-48"
    >
      <template #leading>
        <UAvatar
          :icon="loading ? 'i-lucide-loader-circle' : 'i-lucide-image'"
          size="xl"
          :ui="{ icon: [loading && 'animate-spin'] }"
        />
      </template>
    </UFileUpload>
  </NodeViewWrapper>
</template>
