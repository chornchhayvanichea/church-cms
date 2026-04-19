<template>
  <div class="max-w-4xl mx-auto px-6 py-8">
    <div class="mb-8">
      <p class="text-sm text-muted mb-1">Sermons</p>
      <h1 class="text-2xl font-semibold text-highlighted">Update Sermon</h1>
    </div>

    <div class="flex flex-col gap-6">
      <!-- Basic Info -->
      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">
            Basic Info
          </p></template
        >
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <UFormField label="Title" required class="md:col-span-2">
            <UInput
              v-model="formData.title"
              placeholder="Sermon title"
              class="w-full"
            />
          </UFormField>
          <UFormField label="Speaker" required>
            <UInput
              v-model="formData.speaker"
              placeholder="Speaker name"
              class="w-full"
            />
          </UFormField>
          <UFormField label="Scripture Reference">
            <UInput
              v-model="formData.scripture_reference"
              placeholder="e.g. John 3:16"
              class="w-full"
            />
          </UFormField>
          <UFormField label="Sermon Date" required>
            <UInput v-model="formData.sermon_date" type="date" class="w-full" />
          </UFormField>
          <UFormField label="Publish Date">
            <UInput
              v-model="formData.published_at"
              type="date"
              class="w-full"
            />
          </UFormField>
          <UFormField label="Description" class="md:col-span-2">
            <UTextarea
              v-model="formData.description"
              placeholder="Brief description of the sermon..."
              :rows="3"
              class="w-full"
            />
          </UFormField>
        </div>
      </UCard>

      <!-- Media -->
      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">
            Media
          </p>
        </template>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <UFormField label="Thumbnail">
            <MediaPicker
              v-model="formData.thumbnail"
              accept="image/*"
              mime-type="image"
            />
          </UFormField>
          <UFormField label="Audio">
            <MediaPicker
              v-model="formData.audio"
              accept="audio/*"
              mime-type="audio"
            />
          </UFormField>
          <UFormField label="Video">
            <MediaPicker
              v-model="formData.video"
              accept="video/*"
              mime-type="video"
            />
          </UFormField>
        </div>
      </UCard>

      <!-- Publishing -->
      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">
            Publishing
          </p>
        </template>
        <div class="flex flex-col gap-4">
          <UFormField label="Series">
            <USelect v-model="formData.series_id" :items="seriesOptions" class="w-48" />
          </UFormField>
          <UFormField label="Status">
            <USelect
              v-model="formData.status"
              :items="statusOptions"
              class="w-48"
            />
          </UFormField>
        </div>
      </UCard>

      <!-- Actions -->
      <div class="flex justify-end gap-3">
        <UButton variant="ghost" color="neutral" @click="$router.back()">
          Cancel
        </UButton>
        <UButton :loading="sermonStore.loading" @click="submitHandler">
          Update Sermon
        </UButton>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import MediaPicker from "~/components/dashboard/MediaPicker.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import { SermonStatus, type SermonStoreData } from "~/types/sermonTypes";
import { seriesIndexApi } from "~/services/series";

const sermonStore = useSermonStore();
const toast = useToast();

const statusOptions = [
  { label: "Draft", value: SermonStatus.draft },
  { label: "Published", value: SermonStatus.published },
];

const seriesOptions = ref([{ label: "None", value: null }]);

const formData = ref<SermonStoreData>({
  title: "",
  speaker: "",
  sermon_date: "",
  description: "",
  notes: "",
  scripture_reference: "",
  published_at: "",
  status: SermonStatus.draft,
  series_id: null,
});

const route = useRoute();
const id = route.params.id;

const submitHandler = async () => {
  try {
    await sermonStore.updateSermon(formData.value, Number(id));
    toast.add({ title: "Sermon updated.", color: "success", icon: "i-lucide-check-circle" });
    navigateTo(DASHBOARD_ROUTES.SERMONS);
  } catch (e) {
    toast.add({ title: "Failed to update sermon.", description: getApiErrorMessage(e), color: "error", icon: "i-lucide-x-circle" });
  }
};
onMounted(async () => {
  const [seriesResponse] = await Promise.all([
    seriesIndexApi({ per_page: 100 }),
    sermonStore.getSermon(Number(id)),
  ]);
  seriesOptions.value = [
    { label: "None", value: null },
    ...seriesResponse.data.data.map((s) => ({ label: s.name, value: s.id })),
  ];
  const sermon = sermonStore.sermon;
  if (!sermon) return;
  formData.value = {
    title: sermon.title ?? "",
    speaker: sermon.speaker ?? "",
    sermon_date: sermon.sermon_date ?? "",
    description: sermon.description ?? "",
    thumbnail: sermon.thumbnail ?? undefined,
    audio: sermon.audio ?? undefined,
    video: sermon.video ?? undefined,
    notes: sermon.notes ?? "",
    scripture_reference: sermon.scripture_reference ?? "",
    published_at: sermon.published_at ?? "",
    status: sermon.status ?? SermonStatus.draft,
    series_id: sermon.series_id ?? null,
  };
});
definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});
</script>
