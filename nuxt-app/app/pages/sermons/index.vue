<script setup lang="ts">
import type { PublicSermonIndexParams } from "~/services/sermons";
import sermonBg from "~/assets/images/sermon.png";

const sermonStore = useSermonStore();
const { publicSermons, publicMeta, publicLoading } = storeToRefs(sermonStore);

const search = ref("");
const page = ref(1);
const seriesFilter = ref<number | null>(null);

const buildParams = (): PublicSermonIndexParams => ({
  page: page.value,
  "filter[title]": search.value || undefined,
  "filter[series_id]": seriesFilter.value ?? undefined,
});

const [{ refresh }, { settings }] = await Promise.all([
  useAsyncData("public-sermons", () => sermonStore.getPublicSermons(buildParams())),
  usePublicSettings(),
]);

watch(page, () => refresh());
watch(seriesFilter, () => { page.value = 1; sermonStore.getPublicSermons(buildParams()); });

let searchTimer: ReturnType<typeof setTimeout>;
watch(search, () => {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => { page.value = 1; sermonStore.getPublicSermons(buildParams()); }, 400);
});

const seriesList = computed(() => {
  const map = new Map<number, string>();
  publicSermons.value.forEach((s) => { if (s.series) map.set(s.series.id, s.series.name); });
  return Array.from(map.entries()).map(([id, name]) => ({ id, name }));
});

const formatDate = (d: string) =>
  d ? new Date(d).toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" }) : "";
</script>

<template>
  <div>
    <!-- Hero -->
    <UPageHero
      :title="settings.sermons_hero_title || 'Sermons'"
      :description="settings.sermons_hero_description || 'Listen to messages that encourage, challenge, and grow your faith.'"
      class="bg-cover bg-center bg-fixed min-h-[40%]"
      :style="{
        backgroundImage: `linear-gradient(rgba(255,255,255,0.1), rgba(0,0,0,0.55)), url(${sermonBg})`,
      }"
    />

    <UContainer class="max-w-3xl py-10">
      <!-- Search + series filter -->
      <div class="flex items-center justify-between mb-6">
        <div v-if="seriesList.length" class="flex gap-2 flex-wrap">
          <button
            class="text-sm px-3 py-1 rounded-full border transition-colors"
            :class="seriesFilter === null
              ? 'border-gray-900 dark:border-white text-gray-900 dark:text-white'
              : 'border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-gray-400'"
            @click="seriesFilter = null"
          >
            All
          </button>
          <button
            v-for="s in seriesList"
            :key="s.id"
            class="text-sm px-3 py-1 rounded-full border transition-colors"
            :class="seriesFilter === s.id
              ? 'border-gray-900 dark:border-white text-gray-900 dark:text-white'
              : 'border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-gray-400'"
            @click="seriesFilter = s.id"
          >
            {{ s.name }}
          </button>
        </div>
        <div v-else />
        <UInput
          v-model="search"
          icon="i-lucide-search"
          placeholder="Search..."
          size="sm"
          variant="soft"
          class="w-48"
        />
      </div>

      <!-- Loading -->
      <div v-if="publicLoading" class="space-y-8">
        <div v-for="i in 5" :key="i" class="flex gap-5 animate-pulse">
          <div class="w-28 h-20 bg-gray-100 dark:bg-gray-800 rounded shrink-0" />
          <div class="flex-1 space-y-3">
            <div class="h-5 bg-gray-100 dark:bg-gray-800 rounded w-3/4" />
            <div class="h-4 bg-gray-100 dark:bg-gray-800 rounded w-full" />
            <div class="h-3 bg-gray-100 dark:bg-gray-800 rounded w-32" />
          </div>
        </div>
      </div>

      <!-- Empty -->
      <div v-else-if="publicSermons.length === 0" class="py-20 text-center text-gray-400">
        <p>No sermons yet.</p>
      </div>

      <!-- Feed -->
      <div v-else class="divide-y divide-gray-100 dark:divide-gray-800">
        <NuxtLink
          v-for="sermon in publicSermons"
          :key="sermon.id"
          :to="`/sermons/${sermon.slug}`"
          class="group flex gap-5 py-7 items-start"
        >
          <div class="relative w-32 h-20 shrink-0 overflow-hidden bg-gray-100 dark:bg-gray-800">
            <img
              v-if="sermon.thumbnail"
              :src="sermon.thumbnail"
              :alt="sermon.title"
              class="w-full h-full object-cover group-hover:opacity-80 transition-opacity"
            />
            <div v-else class="w-full h-full bg-gray-100 dark:bg-gray-800" />
            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
              <UIcon name="i-lucide-play" class="w-6 h-6 text-white drop-shadow" />
            </div>
          </div>

          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-1.5">
              <span v-if="sermon.series">{{ sermon.series.name }}</span>
              <span v-if="sermon.series">&bull;</span>
              <span>{{ formatDate(sermon.sermon_date) }}</span>
            </div>
            <h2 class="text-base font-bold text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors leading-snug mb-1">
              {{ sermon.title }}
            </h2>
            <p v-if="sermon.description" class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-2">
              {{ sermon.description }}
            </p>
            <div class="flex items-center gap-3 text-xs text-gray-400 dark:text-gray-500">
              <span v-if="sermon.speaker">{{ sermon.speaker }}</span>
              <span v-if="sermon.video" class="flex items-center gap-1">
                <UIcon name="i-lucide-video" class="w-3 h-3" /> Video
              </span>
              <span v-if="sermon.audio" class="flex items-center gap-1">
                <UIcon name="i-lucide-headphones" class="w-3 h-3" /> Audio
              </span>
            </div>
          </div>
        </NuxtLink>
      </div>

      <!-- Pagination -->
      <div v-if="publicMeta.last_page > 1" class="flex justify-center mt-10">
        <UPagination v-model:page="page" :total="publicMeta.total" :items-per-page="publicMeta.per_page" />
      </div>
    </UContainer>
  </div>
</template>
