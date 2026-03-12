<template>
  <div>
    <UModal v-model:open="isOpen" scrollable title="Upload File">
      <UButton label="Open" color="neutral" variant="subtle" />
      <template #body>
        <UTabs v-model="activeTab" :items="tabItems" />
        <div
          v-show="activeTab === 'library'"
          class="grid grid-cols-3 gap-2 p-4"
        >
          <img
            v-for="image in images"
            :key="image.id"
            :src="image.original_url"
            class="w-full h-24 object-cover cursor-pointer"
            @click="confirmedFromLibrary(image.original_url)"
          />
        </div>
        <div
          v-show="activeTab === 'local'"
          class="justify-center items-center flex"
        >
          <UFileUpload
            v-model="localFile"
            accept="image/*"
            icon="i-lucide-image"
            label="Drop your image here"
            description="SVG, PNG, JPG or GIF (max. 2MB)"
            class="w-96 min-h-48"
          />

          <UButton v-if="localFile" @click="confirmLocal"> confirm </UButton>
        </div>
      </template>
    </UModal>
    <div v-if="previewUrl">
      <UButton @click="removeImg">remove image</UButton>
      <img :src="previewUrl" width="30" height="30" alt="" />
    </div>
  </div>
</template>

<script setup lang="ts">
import type { TabsItem } from "@nuxt/ui";
const activeTab = ref("local");
const tabItems = ref<TabsItem[]>([
  {
    label: "Local",
    value: "local",
  },
  {
    label: "Media Library",
    value: "library",
  },
]);
const mediaStore = useMediaStore();
const { images } = storeToRefs(mediaStore);

const removeImg = () => {
  selected.value = undefined;
};

/**
 * Return a preview URL for the selected media.
 */

const previewUrl = computed(() => {
  if (!selected.value) return null;
  if (typeof selected.value === "string") return selected.value;
  return URL.createObjectURL(selected.value as File);
});

onMounted(async () => {
  await mediaStore.getMedia();
});

const isOpen = ref(false);

const selected = defineModel<string | File>();
const confirmedFromLibrary = (url: string) => {
  selected.value = url;
  isOpen.value = false;
  console.log(selected.value);
};

const localFile = ref<File | undefined>();
const confirmLocal = () => {
  selected.value = localFile.value;
  isOpen.value = false;
};
watch(localFile, (file) => {
  if (file) {
    selected.value = file;
  }
  console.log("local file set:", selected.value);
});

//todo list: bind selected with upload component or just idfk bro
</script>

<style scoped></style>
