<script setup lang="ts">
import ConfirmModal from "~/components/dashboard/ConfirmModal.vue";
import type { DropdownMenuItem, TableColumn } from "@nuxt/ui";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import type { Event } from "~/types/eventTypes";
import type { EventIndexParams } from "~/services/events";

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});

const eventStore = useEventStore();
const { events } = storeToRefs(eventStore);

const page = ref(1);
const search = ref("");
const statusFilter = ref("All");

const statusItems = ["All", "Upcoming", "Past", "Cancelled"];

const UBadge = resolveComponent("UBadge");

const fetchEvents = () => {
  const params: EventIndexParams = { page: page.value };
  if (search.value) params["filter[title]"] = search.value;
  if (statusFilter.value !== "All")
    params["filter[status]"] = statusFilter.value.toLowerCase();
  eventStore.getEvents(params);
};

onMounted(fetchEvents);
watch(page, fetchEvents);
watch(statusFilter, () => {
  page.value = 1;
  fetchEvents();
});

let searchTimer: ReturnType<typeof setTimeout>;
watch(search, () => {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    page.value = 1;
    fetchEvents();
  }, 400);
});

const columns: TableColumn<Event>[] = [
  { id: "action", header: "Action" },
  { accessorKey: "image", header: "Image" },
  { accessorKey: "title", header: "Title" },
  {
    accessorKey: "status",
    header: "Status",
    cell: ({ row }) => {
      const color = {
        upcoming: "success" as const,
        past: "neutral" as const,
        cancelled: "error" as const,
      }[row.getValue("status") as string];
      return h(UBadge, { class: "capitalize", variant: "subtle", color }, () =>
        row.getValue("status"),
      );
    },
  },
  { accessorKey: "event_date", header: "Event Date" },
  { accessorKey: "location", header: "Location" },
  { accessorKey: "creator", header: "Creator" },
];

const toast = useToast();
const selectedId = ref<number | null>(null);
const showConfirmModal = ref(false);

const openDeleteModal = (id: number) => {
  selectedId.value = id;
  showConfirmModal.value = true;
};

const deleteEvent = async () => {
  if (!selectedId.value) return;
  try {
    await eventStore.deleteEvent(selectedId.value);
    toast.add({ title: "Event deleted.", color: "success", icon: "i-lucide-check-circle" });
    showConfirmModal.value = false;
    await fetchEvents();
  } catch (e) {
    toast.add({ title: "Failed to delete event.", description: getApiErrorMessage(e), color: "error", icon: "i-lucide-x-circle" });
    showConfirmModal.value = false;
  }
};

function getDropdownActions(id: number): DropdownMenuItem[][] {
  return [
    [
      {
        label: "Edit",
        icon: "i-lucide-edit",
        to: DASHBOARD_ROUTES.EVENTS_EDIT(id),
      },
      {
        label: "Delete",
        icon: "i-lucide-trash",
        color: "error",
        onSelect: () => openDeleteModal(id),
      },
    ],
  ];
}
</script>

<template>
  <div class="px-6 py-8 space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm text-muted mb-1">Content</p>
        <h1 class="text-2xl font-semibold text-highlighted">Events</h1>
      </div>
      <UButton
        :to="DASHBOARD_ROUTES.EVENTS_CREATE"
        icon="i-lucide-plus"
        label="New Event"
      />
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap gap-3">
      <UInput
        v-model="search"
        icon="i-heroicons-magnifying-glass"
        placeholder="Search title..."
        class="w-64"
      />
      <USelectMenu
        v-model="statusFilter"
        :items="statusItems"
        placeholder="Filter by status"
        class="w-40"
      />
    </div>

    <!-- Table -->
    <UCard>
      <UTable :data="events" :columns="columns">
        <template #action-cell="{ row }">
          <UDropdownMenu :items="getDropdownActions(row.original.id)">
            <UButton
              icon="i-heroicons-ellipsis-vertical-solid"
              color="neutral"
              variant="ghost"
              aria-label="Actions"
            />
          </UDropdownMenu>
        </template>

        <template #image-cell="{ row }">
          <img
            v-if="row.original.image"
            :src="row.original.image"
            :alt="row.original.title"
            class="w-16 h-10 object-cover rounded"
            loading="lazy"
          />
          <div
            v-else
            class="w-16 h-10 rounded bg-(--color-background-secondary) flex items-center justify-center"
          >
            <UIcon name="i-lucide-image" class="text-muted w-4 h-4" />
          </div>
        </template>

        <template #title-cell="{ row }">
          <p class="font-medium text-highlighted max-w-48 truncate">
            {{ row.original.title }}
          </p>
        </template>

        <template #location-cell="{ row }">
          <span class="text-sm text-muted">{{
            row.original.location ?? "—"
          }}</span>
        </template>

        <template #creator-cell="{ row }">
          <div class="flex items-center gap-2.5">
            <UAvatar
              :src="row.original.created_by.avatar"
              :alt="row.original.created_by.name"
              size="sm"
              loading="lazy"
            />
            <p class="text-sm font-medium text-highlighted leading-tight">
              {{ row.original.created_by.name }}
            </p>
          </div>
        </template>
      </UTable>
    </UCard>

    <UPagination
      v-model:page="page"
      :total="eventStore.meta.total"
      :items-per-page="eventStore.meta.per_page"
      class="flex justify-center mt-4"
    />

    <ConfirmModal
      v-model="showConfirmModal"
      message="Are you sure you want to delete this event?"
      @confirm="deleteEvent"
    />
  </div>
</template>
