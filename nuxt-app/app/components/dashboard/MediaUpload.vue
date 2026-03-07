<template>
  <UFileUpload
    v-model="file"
    label="Drop your image here"
    description="SVG, PNG, JPG or GIF (max. 2MB)"
    class="w-96 min-h-48"
  />
</template>
<script setup lang="ts">
const emit = defineEmits<{
  upload: [file: File];
}>();

const file = ref<File | null>(null);

watch(file, (newFile) => {
  if (!newFile) return;
  emit("upload", newFile);
});
</script>
