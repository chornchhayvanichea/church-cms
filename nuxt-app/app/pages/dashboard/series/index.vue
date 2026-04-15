<script setup lang="ts">
import ConfirmModal from "~/components/dashboard/ConfirmModal.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import type { SeriesIndexParams } from "~/services/series";

definePageMeta({ layout: "dashboard", middleware: "dashboard" });

const seriesStore = useSeriesStore();
const { seriesList } = storeToRefs(seriesStore);

const page = ref(1);
const search = ref("");
const expandedIds = ref<Set<number>>(new Set());

const fetchSeries = () => {
  const params: SeriesIndexParams = { page: page.value };
  if (search.value) params["filter[name]"] = search.value;
  seriesStore.getSeriesList(params);
};

onMounted(fetchSeries);
watch(page, fetchSeries);

let searchTimer: ReturnType<typeof setTimeout>;
watch(search, () => {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => { page.value = 1; fetchSeries(); }, 400);
});

const toggle = (id: number) => {
  const next = new Set(expandedIds.value);
  next.has(id) ? next.delete(id) : next.add(id);
  expandedIds.value = next;
};

const selectedId = ref<number | null>(null);
const showConfirmModal = ref(false);

const openDeleteModal = (id: number) => {
  selectedId.value = id;
  showConfirmModal.value = true;
};

const deleteSeries = async () => {
  if (!selectedId.value) return;
  await seriesStore.deleteSeries(selectedId.value);
  await fetchSeries();
};

const formatDateRange = (start?: string, end?: string) => {
  if (!start && !end) return "—";
  if (start && end) return `${start} – ${end}`;
  return start ?? end ?? "—";
};
</script>

<template>
  <div class="px-6 py-8 space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm text-muted mb-1">Content</p>
        <h1 class="text-2xl font-semibold text-highlighted">Series</h1>
      </div>
      <UButton :to="DASHBOARD_ROUTES.SERIES_CREATE" icon="i-lucide-plus" label="New Series" />
    </div>

    <!-- Search -->
    <UInput
      v-model="search"
      icon="i-heroicons-magnifying-glass"
      placeholder="Search series..."
      class="w-64"
    />

    <!-- List -->
    <div class="divide-y divide-default border border-default rounded-md">
      <div v-if="seriesList.length === 0 && !seriesStore.loading" class="py-12 text-center text-sm text-muted">
        No series found.
      </div>

      <div v-for="item in seriesList" :key="item.id">
        <!-- Row -->
        <div
          class="flex items-center gap-4 px-4 py-3 hover:bg-elevated/50 cursor-pointer select-none"
          @click="toggle(item.id)"
        >
          <UIcon
            name="i-lucide-chevron-right"
            class="w-4 h-4 text-muted shrink-0 transition-transform duration-200"
            :class="{ 'rotate-90': expandedIds.has(item.id) }"
          />
          <img
            v-if="item.thumbnail"
            :src="item.thumbnail"
            :alt="item.name"
            class="w-10 h-10 object-cover rounded shrink-0"
          />
          <div v-else class="w-10 h-10 rounded bg-elevated flex items-center justify-center shrink-0">
            <UIcon name="i-lucide-layers" class="w-4 h-4 text-muted" />
          </div>
          <div class="flex-1 min-w-0">
            <p class="font-medium text-highlighted truncate">{{ item.name }}</p>
            <p class="text-xs text-muted">{{ formatDateRange(item.start_date, item.end_date) }}</p>
          </div>
          <span class="text-sm text-muted shrink-0">
            {{ item.sermons.length }} sermon{{ item.sermons.length === 1 ? "" : "s" }}
          </span>
          <div class="flex gap-1 shrink-0" @click.stop>
            <UButton
              icon="i-lucide-edit"
              size="sm"
              color="neutral"
              variant="ghost"
              :to="DASHBOARD_ROUTES.SERIES_EDIT(item.id)"
            />
            <UButton
              icon="i-lucide-trash"
              size="sm"
              color="error"
              variant="ghost"
              @click="openDeleteModal(item.id)"
            />
          </div>
        </div>

        <!-- Expanded sermons -->
        <div v-if="expandedIds.has(item.id)" class="border-t border-default bg-elevated/30">
          <div v-if="item.sermons.length === 0" class="px-10 py-4 text-sm text-muted">
            No sermons in this series.
          </div>
          <table v-else class="w-full text-sm">
            <thead>
              <tr class="text-xs text-muted uppercase tracking-wider border-b border-default">
                <th class="px-10 py-2 text-left font-medium">Title</th>
                <th class="px-4 py-2 text-left font-medium">Speaker</th>
                <th class="px-4 py-2 text-left font-medium">Date</th>
                <th class="px-4 py-2 text-left font-medium">Status</th>
                <th class="px-4 py-2 text-left font-medium">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-default">
              <tr v-for="sermon in item.sermons" :key="sermon.id" class="hover:bg-elevated/50">
                <td class="px-10 py-2.5 font-medium text-highlighted max-w-xs truncate">{{ sermon.title }}</td>
                <td class="px-4 py-2.5 text-muted">{{ sermon.speaker }}</td>
                <td class="px-4 py-2.5 text-muted">{{ sermon.sermon_date }}</td>
                <td class="px-4 py-2.5">
                  <UBadge
                    :color="sermon.status === 'published' ? 'success' : sermon.status === 'archived' ? 'neutral' : 'warning'"
                    variant="subtle"
                    class="capitalize"
                  >
                    {{ sermon.status }}
                  </UBadge>
                </td>
                <td class="px-4 py-2.5">
                  <UButton
                    icon="i-lucide-edit"
                    size="xs"
                    color="neutral"
                    variant="ghost"
                    :to="DASHBOARD_ROUTES.SERMONS_EDIT(sermon.id)"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <UPagination
      v-model:page="page"
      :total="seriesStore.meta.total"
      :items-per-page="seriesStore.meta.per_page"
      class="flex justify-center mt-4"
    />

    <ConfirmModal
      v-model="showConfirmModal"
      message="Are you sure you want to delete this series?"
      @confirm="deleteSeries"
    />
  </div>
</template>
