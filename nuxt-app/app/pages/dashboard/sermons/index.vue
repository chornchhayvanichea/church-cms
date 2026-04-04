<script setup lang="ts">
import type { DropdownMenuItem, TableColumn } from "@nuxt/ui";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import type { Sermon } from "~/types/sermonTypes";

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});
const sermonStore = useSermonStore();
const { sermons } = storeToRefs(sermonStore);
const handleDeleteSermon = async () => {};
const data = computed(() => sermons.value);
onMounted(() => {
  sermonStore.getSermons();
});

const truncate = (str: string | undefined, len = 20) => {
  if (!str) return "";
  return str.length > len ? str.slice(0, len) + "..." : str;
};
const UBadge = resolveComponent("UBadge");
const columns: TableColumn<Sermon>[] = [
  {
    id: "action",
  },

  {
    accessorKey: "id",
    header: "No.",
    cell: ({ row }) => `#${row.getValue("id")}`,
  },
  {
    accessorKey: "thumbnail",
    header: "thumbnail",
  },
  {
    accessorKey: "title",
    header: "title",
  },
  {
    accessorKey: "status",
    header: "status",
    cell: ({ row }) => {
      const color = {
        drafted: "neutral" as const,
        published: "success" as const,
        archived: "secondary" as const,
      }[row.getValue("status") as string];
      return h(UBadge, { class: "capitalize", variant: "subtle", color }, () =>
        row.getValue("status"),
      );
    },
  },

  {
    accessorKey: "audio",
    header: "audio",
  },
  {
    accessorKey: "speaker",
    header: "speaker",
  },
  {
    accessorKey: "video",
    header: "video",
  },
  {
    accessorKey: "sermon_date",
    header: "Date",
  },
  {
    accessorKey: "creator",
    header: "Creator",
    cell: ({ row }) => row.original.created_by.name,
  },
  {
    accessorKey: "published_at",
    header: "Publish Date",
  },
  {
    accessorKey: "description",
    header: "Description",
  },
  {
    accessorKey: "created_at",
    header: "created at",
  },
];
function getDropdownActions(sermon: Sermon): DropdownMenuItem[][] {
  return [
    [
      {
        label: "Edit",
        icon: "i-lucide-edit",
      },
      {
        label: "Delete",
        icon: "i-lucide-trash",
        color: "error",
      },
    ],
  ];
}
</script>
<template>
  <div class="w-full space-y-4 pb-4">
    <UButton :to="DASHBOARD_ROUTES.SERMONS_CREATE" label="create" />
    <UTable :data="data" :columns="columns" class="flex-1">
      <template #thumbnail-cell="{ row }">
        <div class="flex items-center gap-3">
          <img
            :src="row.original.thumbnail"
            :alt="row.original.title"
            class="w-16 h-10 object-cover rounded"
            loading="lazy"
          />
        </div>
      </template>
      <template #audio-cell="{ row }">
        <p v-if="!row.original.audio">empty</p>
        <p v-else>{{ truncate(row.original.audio.split("/").pop()) }}</p>
      </template>
      <template #video-cell="{ row }">
        <p v-if="!row.original.video">empty</p>
        <p v-else>{{ truncate(row.original.video.split("/").pop()) }}</p>
      </template>
      <template #action-cell="{ row }">
        <UDropdownMenu :items="getDropdownActions(row.original)">
          <UButton
            icon="i-lucide-ellipsis-vertical"
            color="neutral"
            variant="ghost"
            aria-label="Actions"
          />
        </UDropdownMenu>
      </template>
      <template #creator-cell="{ row }">
        <div class="flex items-center gap-3">
          <UAvatar
            :src="row.original.created_by.avatar"
            size="lg"
            loading="lazy"
            :alt="`${row.original.created_by.name} avatar`"
          />
          <div>
            <p class="font-medium text-highlighted">
              {{ row.original.created_by.name }}
            </p>
            <p>
              {{ row.original.created_by.role }}
            </p>
          </div>
        </div>
      </template>
    </UTable>
  </div>
</template>
