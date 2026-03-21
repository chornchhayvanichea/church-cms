<template>
  <UModal v-model:open="open" :title="`Upload your ${props.collection}`">
    <UButton label="upload" color="neutral" variant="subtle" />
    <template #body>
      <UFileUpload
        v-model="files"
        :accept="`${props.collection}/*`"
        multiple
        class="min-h-48"
      />
      <UButton
        label="Confirm"
        :loading="mediaStore.loading"
        @click="handleUpload"
      />
    </template>
  </UModal>
</template>

<script setup lang="ts">
import type { MediaCollection } from "~/types/mediaTypes";

const props = defineProps<{ collection: MediaCollection }>();

const mediaStore = useMediaStore();

const files = ref<File[] | null>(null);
const open = ref(false);
const handleUpload = async () => {
  open.value = false;
  if (!files.value?.length) return;
  for (const file of files.value) {
    await mediaStore.uploadMedia({ file, collection: props.collection });
  }
  files.value = null;
};
</script>
