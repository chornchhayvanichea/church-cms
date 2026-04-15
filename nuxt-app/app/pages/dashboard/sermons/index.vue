<script setup lang="ts">
import ConfirmModal from "~/components/dashboard/ConfirmModal.vue";
import type { DropdownMenuItem, TableColumn } from "@nuxt/ui";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import type { Sermon } from "~/types/sermonTypes";
import type { SermonIndexParams } from "~/services/sermons";

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});

const sermonStore = useSermonStore();
const { sermons } = storeToRefs(sermonStore);
const data = computed(() => sermons.value);

const page = ref(1);
const search = ref("");
const statusFilter = ref("All");
const speakerSearch = ref("");

const statusItems = ["All", "Draft", "Published", "Archived"];

const fetchSermons = () => {
  const params: SermonIndexParams = { page: page.value };
  if (search.value) params["filter[title]"] = search.value;
  if (statusFilter.value !== "All") params["filter[status]"] = statusFilter.value.toLowerCase();
  if (speakerSearch.value) params["filter[speaker]"] = speakerSearch.value;
  sermonStore.getSermons(params);
};

onMounted(fetchSermons);

watch(page, fetchSermons);
watch(statusFilter, () => {
  page.value = 1;
  fetchSermons();
});

let searchTimer: ReturnType<typeof setTimeout>;
const onSearchInput = () => {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    page.value = 1;
    fetchSermons();
  }, 400);
};
watch(search, onSearchInput);
watch(speakerSearch, onSearchInput);

const truncate = (str: string | undefined, len = 24) => {
  if (!str) return "";
  return str.length > len ? str.slice(0, len) + "..." : str;
};

const UBadge = resolveComponent("UBadge");

const columns: TableColumn<Sermon>[] = [
  { id: "action", header: "Action" },
  {
    accessorKey: "id",
    header: "No.",
    cell: ({ row }) => `#${row.getValue("id")}`,
  },
  { accessorKey: "thumbnail", header: "Thumbnail" },
  { accessorKey: "title", header: "Title" },
  {
    accessorKey: "status",
    header: "Status",
    cell: ({ row }) => {
      const color = {
        draft: "neutral" as const,
        published: "success" as const,
        archived: "secondary" as const,
      }[row.getValue("status") as string];
      return h(UBadge, { class: "capitalize", variant: "subtle", color }, () =>
        row.getValue("status"),
      );
    },
  },
  { accessorKey: "speaker", header: "Speaker" },
  { accessorKey: "sermon_date", header: "Sermon Date" },
  { accessorKey: "audio", header: "Audio" },
  { accessorKey: "video", header: "Video" },
  { accessorKey: "creator", header: "Creator" },
  { accessorKey: "published_at", header: "Publish Date" },
  { accessorKey: "description", header: "Description" },
  { accessorKey: "created_at", header: "Created At" },
];

const selectedId = ref<number | null>(null);
const showConfirmModal = ref(false);

const openDeleteModal = (id: number) => {
  selectedId.value = id;
  showConfirmModal.value = true;
};

const deleteSermon = async () => {
  if (!selectedId.value) return;
  await sermonStore.deleteSermon(selectedId.value);
  await fetchSermons();
};

function getDropdownActions(sermon: Sermon, id: number): DropdownMenuItem[][] {
  return [
    [
      {
        label: "Edit",
        icon: "i-lucide-edit",
        to: DASHBOARD_ROUTES.SERMONS_EDIT(id),
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
        <h1 class="text-2xl font-semibold text-highlighted">Sermons</h1>
      </div>
      <UButton
        :to="DASHBOARD_ROUTES.SERMONS_CREATE"
        icon="i-lucide-plus"
        label="New Sermon"
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
      <UInput
        v-model="speakerSearch"
        icon="i-lucide-mic"
        placeholder="Search speaker..."
        class="w-48"
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
      <UTable :data="data" :columns="columns">
        <template #action-cell="{ row }">
          <UDropdownMenu
            :items="getDropdownActions(row.original, row.original.id)"
          >
            <UButton
              icon="i-heroicons-ellipsis-vertical-solid"
              color="neutral"
              variant="ghost"
              aria-label="Actions"
            />
          </UDropdownMenu>
        </template>

        <template #thumbnail-cell="{ row }">
          <img
            v-if="row.original.thumbnail"
            :src="row.original.thumbnail"
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

        <template #audio-cell="{ row }">
          <span v-if="!row.original.audio" class="text-muted text-sm">—</span>
          <div v-else class="flex items-center gap-1.5">
            <UIcon
              name="i-lucide-music"
              class="w-3.5 h-3.5 text-muted shrink-0"
            />
            <span class="text-sm">{{
              truncate(row.original.audio.split("/").pop())
            }}</span>
          </div>
        </template>

        <template #video-cell="{ row }">
          <span v-if="!row.original.video" class="text-muted text-sm">—</span>
          <div v-else class="flex items-center gap-1.5">
            <UIcon
              name="i-lucide-video"
              class="w-3.5 h-3.5 text-muted shrink-0"
            />
            <span class="text-sm">{{
              truncate(row.original.video.split("/").pop())
            }}</span>
          </div>
        </template>

        <template #creator-cell="{ row }">
          <div class="flex items-center gap-2.5">
            <UAvatar
              :src="row.original.created_by.avatar"
              :alt="row.original.created_by.name"
              size="sm"
              loading="lazy"
            />
            <div>
              <p class="text-sm font-medium text-highlighted leading-tight">
                {{ row.original.created_by.name }}
              </p>
              <p class="text-xs text-muted leading-tight capitalize">
                {{ row.original.created_by.role }}
              </p>
            </div>
          </div>
        </template>

        <template #description-cell="{ row }">
          <span class="text-sm text-muted">{{
            truncate(row.original.description, 40)
          }}</span>
        </template>
      </UTable>
    </UCard>

    <UPagination
      v-model:page="page"
      :total="sermonStore.meta.total"
      :items-per-page="sermonStore.meta.per_page"
      class="flex justify-center mt-4"
    />

    <ConfirmModal
      v-model="showConfirmModal"
      message="Are you sure you want to delete this sermon?"
      @confirm="deleteSermon"
    />
  </div>
</template>
