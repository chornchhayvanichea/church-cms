<script setup lang="ts">
import eventsBg from "~/assets/images/JesusSave.jpg";
import { EventStatus } from "~/types/eventTypes";

const eventStore = useEventStore();
const { publicEvents, publicMeta, publicLoading } = storeToRefs(eventStore);

const search = ref("");
const page = ref(1);

const [{ refresh }, { settings }] = await Promise.all([
  useAsyncData("public-events", () => eventStore.getPublicEvents({ page: page.value })),
  usePublicSettings(),
]);

watch(page, () => refresh());

let searchTimer: ReturnType<typeof setTimeout>;
watch(search, () => {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    page.value = 1;
    eventStore.getPublicEvents({ page: 1, "filter[title]": search.value || undefined });
  }, 400);
});

const formatDay = (d: string) =>
  d ? new Date(d).toLocaleDateString("en-US", { day: "numeric" }) : "";

const formatMonth = (d: string) =>
  d ? new Date(d).toLocaleDateString("en-US", { month: "short" }).toUpperCase() : "";

const formatDate = (d: string) =>
  d ? new Date(d).toLocaleDateString("en-US", { weekday: "long", month: "long", day: "numeric", year: "numeric" }) : "";

const formatTime = (t: string) =>
  t ? new Date(`1970-01-01T${t}`).toLocaleTimeString("en-US", { hour: "numeric", minute: "2-digit" }) : "";
</script>

<template>
  <div>
    <!-- Hero -->
    <UPageHero
      :title="settings.events_hero_title || 'Events'"
      :description="settings.events_hero_description || 'Gatherings, services, and community events happening at our church.'"
      class="bg-cover bg-center bg-fixed min-h-[40%] pt-16"
      :style="{
        backgroundImage: `linear-gradient(rgba(255,255,255,0.1), rgba(0,0,0,0.55)), url(${eventsBg})`,
      }"
    />

    <UContainer class="max-w-5xl py-12 sm:py-16">
      <!-- Search + count row -->
      <div class="flex items-center justify-between mb-10">
        <p v-if="!publicLoading && publicEvents.length > 0" class="text-sm text-gray-400">
          {{ publicMeta.total }} event{{ publicMeta.total !== 1 ? "s" : "" }}
        </p>
        <div v-else-if="publicLoading" class="h-4 w-20 bg-gray-100 dark:bg-gray-800 rounded animate-pulse" />
        <div v-else />
        <UInput
          v-model="search"
          icon="i-lucide-search"
          placeholder="Search events..."
          size="sm"
          variant="soft"
          class="w-52"
        />
      </div>

      <!-- Loading skeleton -->
      <div v-if="publicLoading" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div v-for="i in 4" :key="i" class="animate-pulse rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800">
          <div class="w-full aspect-video bg-gray-100 dark:bg-gray-800" />
          <div class="p-5 space-y-3">
            <div class="h-3 bg-gray-100 dark:bg-gray-800 rounded w-32" />
            <div class="h-5 bg-gray-100 dark:bg-gray-800 rounded w-3/4" />
            <div class="h-4 bg-gray-100 dark:bg-gray-800 rounded w-full" />
            <div class="h-3 bg-gray-100 dark:bg-gray-800 rounded w-40" />
          </div>
        </div>
      </div>

      <!-- Empty -->
      <div v-else-if="publicEvents.length === 0" class="py-32 text-center">
        <UIcon name="i-lucide-calendar-x" class="w-12 h-12 text-gray-200 dark:text-gray-700 mx-auto mb-4" />
        <p class="text-gray-500 font-medium">No upcoming events.</p>
        <p class="text-gray-400 text-sm mt-1">Check back soon.</p>
      </div>

      <!-- Event cards grid -->
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div
          v-for="event in publicEvents"
          :key="event.id"
          class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 overflow-hidden flex flex-col"
          :class="event.status === EventStatus.cancelled ? 'opacity-60' : ''"
        >
          <!-- Image with date badge -->
          <div class="relative w-full aspect-video bg-gray-100 dark:bg-gray-800 shrink-0">
            <img
              v-if="event.image"
              :src="event.image"
              :alt="event.title"
              class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full flex items-center justify-center">
              <UIcon name="i-lucide-calendar" class="w-10 h-10 text-gray-300 dark:text-gray-600" />
            </div>

            <!-- Date badge -->
            <div class="absolute top-3 left-3 bg-white dark:bg-gray-900 rounded-lg shadow-sm px-2.5 py-1.5 text-center min-w-[42px]">
              <p class="text-[10px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-500 leading-none">
                {{ formatMonth(event.event_date) }}
              </p>
              <p class="text-xl font-bold text-gray-900 dark:text-white leading-tight">
                {{ formatDay(event.event_date) }}
              </p>
            </div>

            <!-- Cancelled badge -->
            <div v-if="event.status === EventStatus.cancelled" class="absolute top-3 right-3">
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">
                Cancelled
              </span>
            </div>
          </div>

          <!-- Content -->
          <div class="p-5 flex flex-col gap-3 flex-1">
            <div>
              <h2 class="text-base font-bold text-gray-900 dark:text-white leading-snug mb-1"
                :class="event.status === EventStatus.cancelled ? 'line-through text-gray-400' : ''"
              >
                {{ event.title }}
              </h2>
              <p v-if="event.description" class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                {{ event.description }}
              </p>
            </div>

            <!-- Meta -->
            <div class="flex flex-col gap-1.5 text-xs text-gray-400 dark:text-gray-500 mt-auto">
              <div class="flex items-center gap-1.5">
                <UIcon name="i-lucide-calendar" class="w-3.5 h-3.5 shrink-0" />
                <span>{{ formatDate(event.event_date) }}</span>
                <span v-if="event.event_time"> &bull; {{ formatTime(event.event_time) }}</span>
              </div>
              <div v-if="event.location" class="flex items-center gap-1.5">
                <UIcon name="i-lucide-map-pin" class="w-3.5 h-3.5 shrink-0" />
                <span>{{ event.location }}</span>
              </div>
            </div>

            <!-- Register -->
            <div v-if="event.registration_link && event.status !== EventStatus.cancelled" class="pt-1">
              <UButton
                as="a"
                :href="event.registration_link"
                target="_blank"
                rel="noopener noreferrer"
                size="sm"
                variant="outline"
                color="neutral"
                trailing-icon="i-lucide-arrow-up-right"
                class="w-full justify-center"
              >
                Register
              </UButton>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="publicMeta.last_page > 1" class="flex justify-center mt-12 pt-8 border-t border-gray-100 dark:border-gray-800">
        <UPagination v-model:page="page" :total="publicMeta.total" :items-per-page="publicMeta.per_page" />
      </div>
    </UContainer>
  </div>
</template>
