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
            <template v-else-if="props.mimeType === 'image'">
              <div
                v-for="media in mediaList"
                :key="media.id"
                class="w-full aspect-square overflow-hidden rounded-md cursor-pointer"
                @click="confirmedFromLibrary(media.original_url)"
              >
                <button>
                  <img
                    :src="media.original_url"
                    class="w-full h-full object-cover"
                  />
                </button>
              </div>
            </template>
            <template v-else-if="props.mimeType === 'audio'">
              <div
                v-for="media in mediaList"
                :key="media.id"
                class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800"
                @click="confirmedFromLibrary(media.original_url)"
              >
                <button>
                  <UIcon
                    name="i-heroicons-musical-note"
                    class="w-6 h-6 text-gray-400"
                  />
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">{{ media.name }}</p>
                    <p class="text-xs text-gray-400">{{ media.mime_type }}</p>
                  </div>
                </button>
              </div>
            </template>
            <div v-else-if="props.mimeType === 'video'">
              <div
                v-for="media in mediaList"
                :key="media.id"
                @click="confirmedFromLibrary(media.original_url)"
              >
                <button>
                  <ClientOnly>
                    <VideoPlayer :item="media" />
                  </ClientOnly>
                </button>
              </div>
            </div>
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
            :accept="`${props.mimeType}/*`"
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
      <UButton @click="removeImg">remove</UButton>
      <img
        v-if="props.mimeType === 'image'"
        :src="previewUrl"
        class="w-full h-48 object-cover rounded-lg"
        alt="thumbnail"
      />
      <video
        v-else-if="props.mimeType === 'video'"
        :src="previewUrl"
        class="w-full h-48 rounded-lg"
        controls
      />
      <audio
        v-else-if="props.mimeType === 'audio'"
        :src="previewUrl"
        class="w-full"
        controls
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import type { TabsItem } from "@nuxt/ui";
import VideoPlayer from "./media/VideoPlayer.vue";

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

const mediaList = computed(() => {
  if (props.mimeType === "image") return mediaStore.ImageMedia;
  if (props.mimeType === "audio") return mediaStore.AudioMedia;
  if (props.mimeType === "video") return mediaStore.VideoMedia;
  return [];
});

const removeImg = () => {
  selected.value = null;
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
  console.log("mimetype", props.mimeType);
  await mediaStore.getMedia(page.value, props.mimeType);
});

watch(page, async (newPage) => {
  await mediaStore.getMedia(newPage, props.mimeType);
});

const isOpen = ref(false);
const selected = defineModel<string | File | null>();

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
const props = defineProps<{
  accept?: string;
  mimeType?: "image" | "audio" | "video";
}>();
</script>
