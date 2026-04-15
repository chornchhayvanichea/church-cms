<template>
  <div class="max-w-2xl mx-auto px-6 py-8">
    <div class="mb-8">
      <p class="text-sm text-muted mb-1">Series</p>
      <h1 class="text-2xl font-semibold text-highlighted">Create Series</h1>
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

      <div class="flex justify-end gap-3">
        <UButton variant="ghost" color="neutral" @click="$router.back()">Cancel</UButton>
        <UButton :loading="seriesStore.loading" @click="submitHandler">Create Series</UButton>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import MediaPicker from "~/components/dashboard/MediaPicker.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import type { SeriesStoreData } from "~/types/seriesTypes";

definePageMeta({ layout: "dashboard", middleware: "dashboard" });

const seriesStore = useSeriesStore();

const formData = ref<SeriesStoreData>({ name: "" });

const submitHandler = async () => {
  await seriesStore.createSeries(formData.value);
  navigateTo(DASHBOARD_ROUTES.SERIES);
};
</script>
