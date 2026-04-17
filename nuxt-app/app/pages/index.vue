<script setup lang="ts">
import type { PageFeatureProps } from "@nuxt/ui";
import crosswheat from "~/assets/images/crosswheat.jpg";
import sermon from "~/assets/images/sermon.png";

const sermonStore = useSermonStore();
const blogStore = useBlogStore();
const eventStore = useEventStore();

const { publicSermons } = storeToRefs(sermonStore);
const { publicBlogs } = storeToRefs(blogStore);
const { publicEvents } = storeToRefs(eventStore);

const [, , , { settings }] = await Promise.all([
  useAsyncData("home-sermons", () => sermonStore.getPublicSermons({ page: 1 })),
  useAsyncData("home-blogs", () => blogStore.getPublicBlogs({ page: 1 })),
  useAsyncData("home-events", () => eventStore.getPublicEvents({ page: 1 })),
  usePublicSettings(),
]);

const latestSermons = computed(() => publicSermons.value.slice(0, 3));
const latestBlogs = computed(() => publicBlogs.value.slice(0, 4));
const upcomingEvents = computed(() => publicEvents.value.slice(0, 3));

const formatDate = (d: string) =>
  d
    ? new Date(d).toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
      })
    : "";

const formatTime = (t: string) =>
  t
    ? new Date(`1970-01-01T${t}`).toLocaleTimeString("en-US", {
        hour: "numeric",
        minute: "2-digit",
      })
    : "";

const stats = computed(() => [
  {
    number: settings.value.home_stat_1_number || "500+",
    label: settings.value.home_stat_1_label || "Active Members",
  },
  {
    number: settings.value.home_stat_2_number || "25+",
    label: settings.value.home_stat_2_label || "Years Serving",
  },
  {
    number: settings.value.home_stat_3_number || "100%",
    label: settings.value.home_stat_3_label || "Faith Based",
  },
]);

const ministries = computed<PageFeatureProps[]>(() => [
  {
    title: settings.value.home_ministry_1_title || "Children's Ministry",
    description: settings.value.home_ministry_1_desc || "",
    icon: "i-lucide-smile",
  },
  {
    title: settings.value.home_ministry_2_title || "Youth Ministry",
    description: settings.value.home_ministry_2_desc || "",
    icon: "i-lucide-zap",
  },
  {
    title: settings.value.home_ministry_3_title || "Community Outreach",
    description: settings.value.home_ministry_3_desc || "",
    icon: "i-lucide-heart",
  },
  {
    title: settings.value.home_ministry_4_title || "Small Groups",
    description: settings.value.home_ministry_4_desc || "",
    icon: "i-lucide-users-round",
  },
]);

const ctaLinks = [{ label: "Get in Touch", to: "/contact" }];
const listenLinks = [
  { label: "Listen", to: "/sermons", icon: "i-lucide-square-play" },
];
</script>

<template>
  <div class="overflow-hidden">
    <!-- Hero -->
    <div
      class="relative w-full min-h-[80vh] flex items-center justify-center bg-gray-900 overflow-hidden"
    >
      <img
        :src="crosswheat"
        alt=""
        class="absolute inset-0 w-full h-full object-cover opacity-50"
      />
      <div class="relative z-10 text-center px-6 max-w-3xl">
        <h1
          class="text-5xl sm:text-7xl font-bold text-white tracking-tight leading-none mb-6"
        >
          {{ settings.home_hero_title || "Jesus Saves You" }}
        </h1>
        <p
          class="text-lg sm:text-xl text-white/70 leading-relaxed mb-10 max-w-lg mx-auto"
        >
          {{
            settings.home_hero_description ||
            "A community built on faith, hope, and love. Join us every Sunday."
          }}
        </p>
        <div class="flex flex-wrap gap-3 justify-center">
          <NuxtLink
            to="/sermons"
            class="px-6 py-3 bg-white text-gray-900 text-sm font-semibold hover:bg-gray-100 transition-colors"
          >
            Listen to Sermons
          </NuxtLink>
          <NuxtLink
            to="/blogs"
            class="px-6 py-3 border border-white text-white text-sm font-semibold hover:bg-white/10 transition-colors"
          >
            Read Blog
          </NuxtLink>
        </div>
      </div>
    </div>

    <!-- Ministries -->
    <UPageSection
      title="Ministries"
      headline="Our Mission"
      :features="ministries"
      :ui="{ features: 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8' }"
      class="bg-gray-100"
    />

    <!-- Stats -->
    <section class="bg-linear-to-r from-slate-900 to-slate-800 py-12 sm:py-16">
      <UContainer>
        <div class="grid grid-cols-3 gap-4 sm:gap-8">
          <div v-for="stat in stats" :key="stat.label" class="text-center">
            <p class="text-3xl sm:text-4xl font-bold text-amber-400">
              {{ stat.number }}
            </p>
            <p class="text-white/70 text-sm sm:text-base mt-2">
              {{ stat.label }}
            </p>
          </div>
        </div>
      </UContainer>
    </section>

    <!-- Upcoming Events -->
    <UPageSection
      title="Upcoming Events"
      description="Join us for these exciting spiritual gatherings and community events."
      headline="What's Happening"
    >
      <div v-if="upcomingEvents.length" class="space-y-6">
        <template v-for="(event, idx) in upcomingEvents" :key="event.id">
          <div class="flex flex-col sm:flex-row gap-8 items-start">
            <div class="flex-1 p-6 sm:p-8">
              <div class="flex items-center gap-2 text-sm text-gray-400 mb-2">
                <UIcon name="i-lucide-calendar" class="w-4 h-4" />
                <span>{{ formatDate(event.event_date) }}</span>
                <span v-if="event.event_time"
                  >&bull; {{ formatTime(event.event_time) }}</span
                >
              </div>
              <h3
                class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-3"
              >
                {{ event.title }}
              </h3>
              <p
                v-if="event.description"
                class="text-base sm:text-lg text-gray-600 dark:text-gray-400 mb-4 leading-relaxed"
              >
                {{ event.description }}
              </p>
              <NuxtLink
                to="/events"
                class="inline-flex items-center gap-2 text-amber-600 font-semibold hover:text-amber-700 transition-colors"
              >
                See all events
                <UIcon name="i-lucide-arrow-right" class="w-4 h-4" />
              </NuxtLink>
            </div>
            <div
              class="w-full sm:w-96 h-64 sm:h-80 rounded-lg overflow-hidden shadow-lg shrink-0 bg-gray-100 dark:bg-gray-800"
            >
              <img
                v-if="event.image"
                :src="event.image"
                :alt="event.title"
                class="w-full h-full object-cover"
              />
              <div
                v-else
                class="w-full h-full flex items-center justify-center"
              >
                <UIcon
                  name="i-lucide-calendar"
                  class="w-12 h-12 text-gray-300 dark:text-gray-600"
                />
              </div>
            </div>
          </div>
          <USeparator v-if="idx < upcomingEvents.length - 1" />
        </template>
      </div>
      <div v-else class="py-10 text-center text-gray-400 text-sm">
        No upcoming events. Check back soon.
      </div>
    </UPageSection>

    <!-- Latest Sermon -->
    <UPageSection
      class="bg-cover bg-center bg-fixed min-h-[50%]"
      :style="{
        backgroundImage: `linear-gradient(rgba(255,255,255,0.2), rgba(0,0,0,0.4)), url(${sermon})`,
      }"
      title="Latest Sermon"
      orientation="horizontal"
      headline="This week sermon"
      :description="
        settings.home_sermon_section_desc ||
        'Join us every week as we dive into Scripture and grow together in faith.'
      "
      :links="listenLinks"
      :ui="{ description: 'text-white', title: 'text-gray-100' }"
    />

    <!-- Latest Sermons (real data) -->
    <UContainer class="max-w-3xl py-16">
      <div
        class="flex items-center justify-between pb-6 border-b border-gray-100 dark:border-gray-800 mb-2"
      >
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
          Recent Sermons
        </h2>
        <NuxtLink
          to="/sermons"
          class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
        >
          All sermons →
        </NuxtLink>
      </div>

      <div
        v-if="latestSermons.length"
        class="divide-y divide-gray-100 dark:divide-gray-800"
      >
        <NuxtLink
          v-for="s in latestSermons"
          :key="s.id"
          :to="`/sermons/${s.slug}`"
          class="group flex gap-5 py-7 items-start"
        >
          <div
            class="relative w-32 h-20 shrink-0 overflow-hidden bg-gray-100 dark:bg-gray-800"
          >
            <img
              v-if="s.thumbnail"
              :src="s.thumbnail"
              :alt="s.title"
              class="w-full h-full object-cover group-hover:opacity-80 transition-opacity"
            />
            <div v-else class="w-full h-full bg-gray-100 dark:bg-gray-800" />
            <div
              class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
            >
              <UIcon
                name="i-lucide-play"
                class="w-6 h-6 text-white drop-shadow"
              />
            </div>
          </div>
          <div class="flex-1 min-w-0">
            <div
              class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-1.5"
            >
              <span v-if="s.series">{{ s.series.name }}</span>
              <span v-if="s.series">&bull;</span>
              <span>{{ formatDate(s.sermon_date) }}</span>
            </div>
            <h3
              class="text-base font-bold text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors leading-snug mb-1"
            >
              {{ s.title }}
            </h3>
            <p
              v-if="s.description"
              class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2"
            >
              {{ s.description }}
            </p>
          </div>
        </NuxtLink>
      </div>
      <div v-else class="py-12 text-center text-gray-400 text-sm">
        No sermons yet.
      </div>
    </UContainer>

    <div class="border-t border-gray-100 dark:border-gray-800" />

    <!-- Latest Blogs (real data) -->
    <UContainer class="max-w-3xl py-16">
      <div
        class="flex items-center justify-between pb-6 border-b border-gray-100 dark:border-gray-800 mb-2"
      >
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
          Latest Articles
        </h2>
        <NuxtLink
          to="/blogs"
          class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
        >
          All articles →
        </NuxtLink>
      </div>

      <div
        v-if="latestBlogs.length"
        class="divide-y divide-gray-100 dark:divide-gray-800"
      >
        <NuxtLink
          v-for="blog in latestBlogs"
          :key="blog.id"
          :to="`/blogs/${blog.slug}`"
          class="group flex gap-6 py-8 items-start"
        >
          <div class="flex-1 min-w-0">
            <div
              class="flex items-center gap-2 text-sm text-gray-400 dark:text-gray-500 mb-2"
            >
              <span>{{ blog.author?.name }}</span>
              <span>&bull;</span>
              <span>{{ formatDate(blog.published_at) }}</span>
            </div>
            <h3
              class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors leading-snug mb-2"
            >
              {{ blog.title }}
            </h3>
            <p
              v-if="blog.excerpt"
              class="text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2 text-sm"
            >
              {{ blog.excerpt }}
            </p>
          </div>
          <div
            v-if="blog.thumbnail"
            class="w-28 h-20 shrink-0 overflow-hidden bg-gray-100 dark:bg-gray-800"
          >
            <img
              :src="blog.thumbnail"
              :alt="blog.title"
              class="w-full h-full object-cover group-hover:opacity-90 transition-opacity"
            />
          </div>
        </NuxtLink>
      </div>
      <div v-else class="py-12 text-center text-gray-400 text-sm">
        No articles yet.
      </div>
    </UContainer>

    <!-- CTA -->
    <UPageCTA
      :title="settings.home_cta_title || 'Ready to Join Our Community?'"
      :description="
        settings.home_cta_description || 'We\'d love to see you this Sunday!'
      "
      :links="ctaLinks"
    />
  </div>
</template>
