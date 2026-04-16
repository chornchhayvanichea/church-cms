<script setup lang="ts">
import eventsBg from "~/assets/images/JesusSave.jpg";

const eventStore = useEventStore();
const { publicEvents, publicMeta, publicLoading } = storeToRefs(eventStore);

const search = ref("");
const page = ref(1);

const { refresh } = await useAsyncData("public-events", () =>
  eventStore.getPublicEvents({ page: page.value }),
);

watch(page, () => refresh());

let searchTimer: ReturnType<typeof setTimeout>;
watch(search, () => {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    page.value = 1;
    eventStore.getPublicEvents({ page: 1, "filter[title]": search.value || undefined });
  }, 400);
});

const formatDate = (d: string) =>
  d ? new Date(d).toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" }) : "";

const formatTime = (t: string) =>
  t ? new Date(`1970-01-01T${t}`).toLocaleTimeString("en-US", { hour: "numeric", minute: "2-digit" }) : "";
</script>

<template>
  <div>
    <!-- Hero -->
    <UPageHero
      title="Events"
      description="Gatherings, services, and community events happening at our church."
      class="bg-cover bg-center bg-fixed min-h-[40%]"
      :style="{
        backgroundImage: `linear-gradient(rgba(255,255,255,0.1), rgba(0,0,0,0.55)), url(${eventsBg})`,
      }"
    />

    <UContainer class="max-w-3xl py-10">
      <!-- Search -->
      <div class="flex justify-end mb-8">
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
      <div v-if="publicLoading" class="space-y-6">
        <div v-for="i in 5" :key="i" class="flex gap-6 animate-pulse">
          <div class="w-28 h-20 bg-gray-100 dark:bg-gray-800 rounded shrink-0" />
          <div class="flex-1 space-y-3">
            <div class="h-3 bg-gray-100 dark:bg-gray-800 rounded w-24" />
            <div class="h-5 bg-gray-100 dark:bg-gray-800 rounded w-3/4" />
            <div class="h-4 bg-gray-100 dark:bg-gray-800 rounded w-full" />
            <div class="h-3 bg-gray-100 dark:bg-gray-800 rounded w-32" />
          </div>
        </div>
      </div>

      <!-- Empty -->
      <div v-else-if="publicEvents.length === 0" class="py-20 text-center text-gray-400">
        <p>No upcoming events.</p>
      </div>

      <!-- Feed -->
      <div v-else class="divide-y divide-gray-100 dark:divide-gray-800">
        <div
          v-for="event in publicEvents"
          :key="event.id"
          class="flex gap-6 py-8 items-start"
        >
          <!-- Image -->
          <div class="w-28 h-20 shrink-0 overflow-hidden bg-gray-100 dark:bg-gray-800">
            <img
              v-if="event.image"
              :src="event.image"
              :alt="event.title"
              class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full flex items-center justify-center">
              <UIcon name="i-lucide-calendar" class="w-6 h-6 text-gray-300 dark:text-gray-600" />
            </div>
          </div>

          <!-- Info -->
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-1.5">
              <UIcon name="i-lucide-calendar" class="w-3 h-3" />
              <span>{{ formatDate(event.event_date) }}</span>
              <span v-if="event.event_time">&bull; {{ formatTime(event.event_time) }}</span>
            </div>
            <h2 class="text-base font-bold text-gray-900 dark:text-white leading-snug mb-1">
              {{ event.title }}
            </h2>
            <p v-if="event.description" class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-2">
              {{ event.description }}
            </p>
            <div class="flex items-center gap-3 text-xs text-gray-400 dark:text-gray-500">
              <span v-if="event.location" class="flex items-center gap-1">
                <UIcon name="i-lucide-map-pin" class="w-3 h-3" /> {{ event.location }}
              </span>
              <a
                v-if="event.registration_link"
                :href="event.registration_link"
                target="_blank"
                class="flex items-center gap-1 text-amber-600 hover:text-amber-700 transition-colors font-medium"
                @click.stop
              >
                Register <UIcon name="i-lucide-arrow-up-right" class="w-3 h-3" />
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="publicMeta.last_page > 1" class="flex justify-center mt-10">
        <UPagination v-model:page="page" :total="publicMeta.total" :items-per-page="publicMeta.per_page" />
      </div>
    </UContainer>
  </div>
</template>
