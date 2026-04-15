<template>
  <div class="max-w-4xl mx-auto px-6 py-8">
    <div class="mb-8">
      <p class="text-sm text-muted mb-1">Events</p>
      <h1 class="text-2xl font-semibold text-highlighted">Edit Event</h1>
    </div>

    <div class="flex flex-col gap-6">
      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">Basic Info</p>
        </template>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <UFormField label="Title" required class="md:col-span-2">
            <UInput v-model="formData.title" placeholder="Event title" class="w-full" />
          </UFormField>
          <UFormField label="Description" class="md:col-span-2">
            <UTextarea v-model="formData.description" placeholder="Event description..." :rows="3" class="w-full" />
          </UFormField>
          <UFormField label="Event Date" required>
            <UInput v-model="formData.event_date" type="date" class="w-full" />
          </UFormField>
          <UFormField label="Event Time">
            <UInput v-model="formData.event_time" type="time" class="w-full" />
          </UFormField>
          <UFormField label="End Date">
            <UInput v-model="formData.end_date" type="date" class="w-full" />
          </UFormField>
          <UFormField label="End Time">
            <UInput v-model="formData.end_time" type="time" class="w-full" />
          </UFormField>
          <UFormField label="Location" class="md:col-span-2">
            <UInput v-model="formData.location" placeholder="Event location" class="w-full" />
          </UFormField>
          <UFormField label="Registration Link" class="md:col-span-2">
            <UInput v-model="formData.registration_link" placeholder="https://..." class="w-full" />
          </UFormField>
        </div>
      </UCard>

      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">Image</p>
        </template>
        <UFormField label="Event Image">
          <MediaPicker v-model="formData.image" accept="image/*" mime-type="image" />
        </UFormField>
      </UCard>

      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">Publishing</p>
        </template>
        <UFormField label="Status">
          <USelect v-model="formData.status" :items="statusOptions" class="w-48" />
        </UFormField>
      </UCard>

      <div class="flex justify-end gap-3">
        <UButton variant="ghost" color="neutral" @click="$router.back()">Cancel</UButton>
        <UButton :loading="eventStore.loading" @click="submitHandler">Update Event</UButton>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import MediaPicker from "~/components/dashboard/MediaPicker.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import { EventStatus, type EventStoreData } from "~/types/eventTypes";

definePageMeta({ layout: "dashboard", middleware: "dashboard" });

const eventStore = useEventStore();
const route = useRoute();
const id = Number(route.params.id);

const statusOptions = [
  { label: "Upcoming", value: EventStatus.upcoming },
  { label: "Past", value: EventStatus.past },
  { label: "Cancelled", value: EventStatus.cancelled },
];

const formData = ref<EventStoreData>({
  title: "",
  event_date: "",
  status: EventStatus.upcoming,
});

onMounted(async () => {
  await eventStore.getEvent(id);
  const event = eventStore.event;
  if (!event) return;
  formData.value = {
    title: event.title ?? "",
    description: event.description ?? "",
    event_date: event.event_date ?? "",
    event_time: event.event_time ?? "",
    end_date: event.end_date ?? "",
    end_time: event.end_time ?? "",
    location: event.location ?? "",
    registration_link: event.registration_link ?? "",
    image: event.image ?? undefined,
    status: event.status ?? EventStatus.upcoming,
  };
});

const submitHandler = async () => {
  await eventStore.updateEvent(formData.value, id);
  navigateTo(DASHBOARD_ROUTES.EVENTS);
};
</script>
