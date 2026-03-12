<template>
  <div class="space-y-5 p-5">
    <!-- Blog Posts Grid -->
    <div class="flex items-center gap-2">
      <div class="mr-auto flex gap-2">
        <USelect v-model="sortValue" :items="sortItems" />
        <UButton>Upload</UButton>
      </div>

      <UButton icon="i-lucide-grid-2x2" variant="outline" />
      <UButton icon="i-lucide-list" variant="outline" />
    </div>
    <div
      class="grid gap-3"
      style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))"
    >
      <div
        v-for="image in filteredImages"
        :key="image.id"
        class="relative group"
      >
        <UCard
          :ui="{
            root: 'rounded-none',
            body: 'p-0 sm:p-0',
          }"
          variant="soft"
        >
          <img :src="image.original_url" class="w-full h-48 object-cover" />
        </UCard>
        <!-- Action buttons on hover -->
        <div
          class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex gap-2"
        >
          <UButton
            icon="i-heroicons-eye"
            color="primary"
            variant="ghost"
            size="sm"
            @click="openPreview(image.original_url)"
          />
          <UButton
            icon="i-heroicons-trash"
            color="primary"
            variant="ghost"
            size="sm"
            @click="deleteImage(image.id)"
          />
        </div>
      </div>
    </div>
    <UModal v-model:open="isOpen" fullscreen>
      <template #content>
        <div
          class="relative w-full h-full flex items-center justify-center bg-black"
        >
          <UButton
            icon="i-heroicons-x-mark"
            color="primary"
            variant="ghost"
            class="absolute top-4 right-4 z-10"
            @click="isOpen = false"
          />
          <img
            :src="selectedImage!"
            class="max-w-full max-h-full object-contain cursor-zoom-in"
            :style="{
              transform: `scale(${zoom})`,
              transition: 'transform 0.2s',
            }"
            @wheel.prevent="handleZoom"
          />
        </div>
      </template>
    </UModal>
    <UPagination
      v-model:page="page"
      :total="mediaStore.meta.total"
      :items-per-page="mediaStore.meta.per_page"
      class="flex justify-center mt-8"
    />
  </div>
</template>

<script setup lang="ts">
const page = ref(1);
onMounted(async () => {
  await mediaStore.getMedia(page.value, "image");
});

watch(page, async (newPage) => {
  await mediaStore.getMedia(newPage, "image");
});

const sortItems = ref([
  "Recents",
  "Last week",
  "Last month",
  "Decend",
  "Ascend",
]);
const sortValue = useState("sort", () => "Ascend");

const selectedImage = ref<string | null>(null);
const isOpen = ref(false);

const zoom = ref(1);
const handleZoom = (e: WheelEvent) => {
  zoom.value = Math.min(Math.max(zoom.value - e.deltaY * 0.001, 0.5), 5);
};

const openPreview = (url: string) => {
  selectedImage.value = url;
  zoom.value = 1;
  isOpen.value = true;
};
const mediaStore = useMediaStore();
const { images } = storeToRefs(mediaStore);

const deleteImage = async (id: number) => {
  await mediaStore.removeMedia(id);
  console.log();
};
const filteredImages = computed(() => images.value);
</script>
