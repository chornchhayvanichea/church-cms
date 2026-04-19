<template>
  <div class="max-w-2xl mx-auto px-6 py-8">
    <div class="mb-8">
      <p class="text-sm text-muted mb-1">Series</p>
      <h1 class="text-2xl font-semibold text-highlighted">Edit Series</h1>
    </div>

    <div class="flex flex-col gap-6">
      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">Details</p>
        </template>
        <div class="flex flex-col gap-4">
          <UFormField label="Name" required>
            <UInput v-model="formData.name" placeholder="Series name" class="w-full" />
          </UFormField>
          <UFormField label="Description">
            <UTextarea v-model="formData.description" placeholder="Brief description..." :rows="3" class="w-full" />
          </UFormField>
          <div class="grid grid-cols-2 gap-4">
            <UFormField label="Start Date">
              <UInput v-model="formData.start_date" type="date" class="w-full" />
            </UFormField>
            <UFormField label="End Date">
              <UInput v-model="formData.end_date" type="date" class="w-full" />
            </UFormField>
          </div>
        </div>
      </UCard>

      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">Thumbnail</p>
        </template>
        <UFormField label="Thumbnail">
          <MediaPicker v-model="formData.thumbnail" accept="image/*" mime-type="image" />
        </UFormField>
      </UCard>

      <!-- Sermons -->
      <UCard>
        <template #header>
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-muted uppercase tracking-wider">Sermons</p>
            <span class="text-xs text-muted">{{ selectedSermonIds.length }} sermon{{ selectedSermonIds.length !== 1 ? 's' : '' }}</span>
          </div>
        </template>
        <div class="flex flex-col gap-4">
          <!-- Search to add -->
          <UFormField label="Add Sermon">
            <USelect
              v-model="addSermonId"
              :items="availableSermonOptions"
              placeholder="Search and select a sermon..."
              class="w-full"
              @update:model-value="addSermon"
            />
          </UFormField>

          <!-- Current sermons in series -->
          <div v-if="selectedSermons.length > 0" class="flex flex-col divide-y divide-default">
            <div
              v-for="sermon in selectedSermons"
              :key="sermon.id"
              class="flex items-center justify-between py-2.5"
            >
              <div class="flex flex-col gap-0.5">
                <span class="text-sm font-medium text-highlighted">{{ sermon.title }}</span>
                <span class="text-xs text-muted">{{ sermon.speaker }} · {{ sermon.sermon_date }}</span>
              </div>
              <UButton
                variant="ghost"
                color="neutral"
                size="xs"
                icon="i-lucide-x"
                @click="removeSermon(sermon.id)"
              />
            </div>
          </div>
          <p v-else class="text-sm text-muted py-2">No sermons added yet.</p>
        </div>
      </UCard>

      <div class="flex justify-end gap-3">
        <UButton variant="ghost" color="neutral" @click="$router.back()">Cancel</UButton>
        <UButton :loading="seriesStore.loading" @click="submitHandler">Update Series</UButton>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import MediaPicker from "~/components/dashboard/MediaPicker.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import type { SeriesStoreData } from "~/types/seriesTypes";
import type { Sermon } from "~/types/sermonTypes";
import { seriesSyncSermonsApi } from "~/services/series";
import { sermonIndexApi } from "~/services/sermons";

definePageMeta({ layout: "dashboard", middleware: "dashboard" });

const seriesStore = useSeriesStore();
const toast = useToast();
const route = useRoute();
const id = Number(route.params.id);

const formData = ref<SeriesStoreData>({ name: "" });
const allSermons = ref<Sermon[]>([]);
const selectedSermonIds = ref<number[]>([]);
const addSermonId = ref<number | null>(null);

const selectedSermons = computed(() =>
  allSermons.value.filter((s) => selectedSermonIds.value.includes(s.id))
);

const availableSermonOptions = computed(() =>
  allSermons.value
    .filter((s) => !selectedSermonIds.value.includes(s.id))
    .map((s) => ({ label: s.title, value: s.id }))
);

const addSermon = (val: number | null) => {
  if (val && !selectedSermonIds.value.includes(val)) {
    selectedSermonIds.value.push(val);
  }
  addSermonId.value = null;
};

const removeSermon = (sermonId: number) => {
  selectedSermonIds.value = selectedSermonIds.value.filter((id) => id !== sermonId);
};

onMounted(async () => {
  const [sermonsResponse] = await Promise.all([
    sermonIndexApi({ per_page: 100 }),
    seriesStore.getSeries(id),
  ]);
  allSermons.value = sermonsResponse.data.data;

  const s = seriesStore.series;
  if (!s) return;

  formData.value = {
    name: s.name ?? "",
    description: s.description ?? "",
    start_date: s.start_date ?? "",
    end_date: s.end_date ?? "",
    thumbnail: s.thumbnail ?? undefined,
  };

  selectedSermonIds.value = (s.sermons ?? []).map((sermon) => sermon.id);
});

const submitHandler = async () => {
  try {
    await Promise.all([
      seriesStore.updateSeries(formData.value, id),
      seriesSyncSermonsApi(id, selectedSermonIds.value),
    ]);
    toast.add({ title: "Series updated.", color: "success", icon: "i-lucide-check-circle" });
    navigateTo(DASHBOARD_ROUTES.SERIES);
  } catch (e) {
    toast.add({ title: "Failed to update series.", description: getApiErrorMessage(e), color: "error", icon: "i-lucide-x-circle" });
  }
};
</script>
