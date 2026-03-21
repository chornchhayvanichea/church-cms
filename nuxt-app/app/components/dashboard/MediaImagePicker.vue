<template>
  <div class="space-y-3 mb-3">
    <UModal v-model:open="isOpen" title="Upload File">
      <UButton v-if="!previewUrl" label="Open" color="neutral" variant="subtle">
        Upload</UButton
      >
      <template #body>
        <UTabs v-model="activeTab" :items="tabItems" />
        <div v-show="activeTab === 'library'">
          <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 p-4"
          >
            <template v-if="mediaStore.loading">
              <USkeleton
                v-for="i in 30"
                :key="i"
                class="w-full aspect-square rounded-md"
              />
            </template>
            <template v-else>
              <div
                v-for="image in images"
                :key="image.id"
                class="w-full aspect-square overflow-hidden rounded-md cursor-pointer"
                @click="confirmedFromLibrary(image.original_url)"
              >
                <button>
                  <img
                    :src="image.original_url"
                    class="w-full h-full object-cover"
                  />
                </button>
              </div>
            </template>
          </div>
          <div class="flex justify-center mt-4">
            <UPagination
              v-model:page="page"
              :total="mediaStore.meta.total"
              :items-per-page="mediaStore.meta.per_page"
            />
          </div>
        </div>
        <div
          v-show="activeTab === 'local'"
          class="flex flex-col items-center gap-4"
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
    <div v-if="previewUrl" class="max-w-2xs space-y-3">
      <UButton @click="removeImg">remove image</UButton>
      <img
        :src="previewUrl"
        class="w-full h-48 object-cover rounded-lg"
        alt="thumbnail"
      />
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
  localFile.value = undefined;
};

/**
 * Return a preview URL for the selected media.
 */
const previewUrl = computed(() => {
  if (!selected.value) return null;
  if (typeof selected.value === "string") return selected.value;
  return URL.createObjectURL(selected.value as File);
});

/**
 * pagination
 */
const page = ref(1);

onMounted(async () => {
  await mediaStore.getMedia(page.value, "image");
});

watch(page, async (newPage) => {
  await mediaStore.getMedia(newPage, "image");
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
</script>
