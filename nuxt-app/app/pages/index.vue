<script setup lang="ts">
import type { PageFeatureProps } from "@nuxt/ui";
import crosswheat from "~/assets/images/crosswheat.jpg";
import sermon from "~/assets/images/sermon.png";

const sermonStore = useSermonStore();
const blogStore = useBlogStore();

const { publicSermons } = storeToRefs(sermonStore);
const { publicBlogs } = storeToRefs(blogStore);

await Promise.all([
  useAsyncData("home-sermons", () => sermonStore.getPublicSermons({ page: 1 })),
  useAsyncData("home-blogs", () => blogStore.getPublicBlogs({ page: 1 })),
]);

const latestSermons = computed(() => publicSermons.value.slice(0, 3));
const latestBlogs = computed(() => publicBlogs.value.slice(0, 4));

const formatDate = (d: string) =>
  d ? new Date(d).toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" }) : "";

const eventItems = [
  {
    title: "Sunday Worship Service",
    description: "Join us every Sunday morning at 10 AM for an inspiring worship experience.",
    icon: "i-lucide-music",
    image: "https://picsum.photos/400/300?random=2",
    to: "/events/sunday-worship",
  },
  {
    title: "Midweek Prayer Meeting",
    description: "Wednesday evenings, we gather to intercede for our community.",
    icon: "i-lucide-heart-handshake",
    image: "https://picsum.photos/400/300?random=3",
    to: "/events/prayer-meeting",
  },
  {
    title: "Youth Group Gathering",
    description: "A dynamic space for young believers to grow in faith and build friendships.",
    icon: "i-lucide-users",
    image: "https://picsum.photos/400/300?random=4",
    to: "/events/youth-group",
  },
];

const stats = [
  { number: "500+", label: "Active Members" },
  { number: "25+", label: "Years Serving" },
  { number: "100%", label: "Faith Based" },
];

const ministries = ref<PageFeatureProps[]>([
  {
    title: "Children's Ministry",
    description: "A safe, fun environment where kids learn about Jesus and grow in faith.",
    icon: "i-lucide-smile",
  },
  {
    title: "Youth Ministry",
    description: "Empowering young people to live out their faith with purpose and passion.",
    icon: "i-lucide-zap",
  },
  {
    title: "Community Outreach",
    description: "Serving our neighbors and making a real difference in our community.",
    icon: "i-lucide-heart",
  },
  {
    title: "Small Groups",
    description: "Connect deeply with others through meaningful Bible study and fellowship.",
    icon: "i-lucide-users-round",
  },
]);

const ctaLinks = [{ label: "Get in Touch", to: "/contact" }];
const listenLinks = [{ label: "Listen", to: "/sermons", icon: "i-lucide-square-play" }];
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
        <h1 class="text-5xl sm:text-7xl font-bold text-white tracking-tight leading-none mb-6">
          Jesus Saves You
        </h1>
        <p class="text-lg sm:text-xl text-white/70 leading-relaxed mb-10 max-w-lg mx-auto">
          A community built on faith, hope, and love. Join us every Sunday.
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
            <p class="text-3xl sm:text-4xl font-bold text-amber-400">{{ stat.number }}</p>
            <p class="text-white/70 text-sm sm:text-base mt-2">{{ stat.label }}</p>
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
      <div class="space-y-6">
        <template v-for="(event, idx) in eventItems" :key="event.title">
          <div class="flex flex-col sm:flex-row gap-8 items-start">
            <div class="flex-1 p-6 sm:p-8">
              <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">{{ event.title }}</h3>
              <p class="text-base sm:text-lg text-gray-600 mb-4 leading-relaxed">{{ event.description }}</p>
              <NuxtLink
                :to="event.to"
                class="inline-flex items-center gap-2 text-amber-600 font-semibold hover:text-amber-700 transition-colors"
              >
                Learn More <UIcon name="i-lucide-arrow-right" class="w-4 h-4" />
              </NuxtLink>
            </div>
            <div class="w-full sm:w-96 h-64 sm:h-80 rounded-lg overflow-hidden shadow-lg shrink-0">
              <img :src="event.image" :alt="event.title" class="w-full h-full object-cover" />
            </div>
          </div>
          <USeparator v-if="idx < eventItems.length - 1" />
        </template>
      </div>
    </UPageSection>

    <!-- Latest Sermon -->
    <UPageSection
      class="bg-cover bg-center bg-fixed min-h-[50%]"
      :style="{ backgroundImage: `linear-gradient(rgba(255,255,255,0.2), rgba(0,0,0,0.4)), url(${sermon})` }"
      title="Latest Sermon"
      orientation="horizontal"
      headline="This week sermon"
      description="Eu, pellentesque ligula dui sed, velit consequat ac bibendum eleifend praesent erat. Odio nibh maximus ligula faucibus, nunc tincidunt leo tortor facilisis vitae ut."
      :links="listenLinks"
      :ui="{ description: 'text-white', title: 'text-gray-100' }"
    />

    <!-- Latest Sermons (real data) -->
    <UContainer class="max-w-3xl py-16">
      <div class="flex items-center justify-between pb-6 border-b border-gray-100 dark:border-gray-800 mb-2">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Recent Sermons</h2>
        <NuxtLink
          to="/sermons"
          class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
        >
          All sermons →
        </NuxtLink>
      </div>

      <div v-if="latestSermons.length" class="divide-y divide-gray-100 dark:divide-gray-800">
        <NuxtLink
          v-for="s in latestSermons"
          :key="s.id"
          :to="`/sermons/${s.slug}`"
          class="group flex gap-5 py-7 items-start"
        >
          <div class="relative w-32 h-20 shrink-0 overflow-hidden bg-gray-100 dark:bg-gray-800">
            <img
              v-if="s.thumbnail"
              :src="s.thumbnail"
              :alt="s.title"
              class="w-full h-full object-cover group-hover:opacity-80 transition-opacity"
            />
            <div v-else class="w-full h-full bg-gray-100 dark:bg-gray-800" />
            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
              <UIcon name="i-lucide-play" class="w-6 h-6 text-white drop-shadow" />
            </div>
          </div>
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-1.5">
              <span v-if="s.series">{{ s.series.name }}</span>
              <span v-if="s.series">&bull;</span>
              <span>{{ formatDate(s.sermon_date) }}</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors leading-snug mb-1">
              {{ s.title }}
            </h3>
            <p v-if="s.description" class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
              {{ s.description }}
            </p>
          </div>
        </NuxtLink>
      </div>
      <div v-else class="py-12 text-center text-gray-400 text-sm">No sermons yet.</div>
    </UContainer>

    <div class="border-t border-gray-100 dark:border-gray-800" />

    <!-- Latest Blogs (real data) -->
    <UContainer class="max-w-3xl py-16">
      <div class="flex items-center justify-between pb-6 border-b border-gray-100 dark:border-gray-800 mb-2">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Latest Articles</h2>
        <NuxtLink
          to="/blogs"
          class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
        >
          All articles →
        </NuxtLink>
      </div>

      <div v-if="latestBlogs.length" class="divide-y divide-gray-100 dark:divide-gray-800">
        <NuxtLink
          v-for="blog in latestBlogs"
          :key="blog.id"
          :to="`/blogs/${blog.slug}`"
          class="group flex gap-6 py-8 items-start"
        >
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 text-sm text-gray-400 dark:text-gray-500 mb-2">
              <span>{{ blog.author?.name }}</span>
              <span>&bull;</span>
              <span>{{ formatDate(blog.published_at) }}</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors leading-snug mb-2">
              {{ blog.title }}
            </h3>
            <p v-if="blog.excerpt" class="text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2 text-sm">
              {{ blog.excerpt }}
            </p>
          </div>
          <div v-if="blog.thumbnail" class="w-28 h-20 shrink-0 overflow-hidden bg-gray-100 dark:bg-gray-800">
            <img
              :src="blog.thumbnail"
              :alt="blog.title"
              class="w-full h-full object-cover group-hover:opacity-90 transition-opacity"
            />
          </div>
        </NuxtLink>
      </div>
      <div v-else class="py-12 text-center text-gray-400 text-sm">No articles yet.</div>
    </UContainer>

    <!-- CTA -->
    <UPageCTA
      title="Ready to Join Our Community?"
      description="We'd love to see you this Sunday! Experience authentic worship, spiritual growth, and meaningful fellowship."
      :links="ctaLinks"
    />
  </div>
</template>
