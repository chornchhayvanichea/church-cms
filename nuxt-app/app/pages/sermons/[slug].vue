<script setup lang="ts">
import DOMPurify from "dompurify";

const route = useRoute();
const sermonStore = useSermonStore();
const { publicSermon, publicLoading } = storeToRefs(sermonStore);

const { error } = await useAsyncData(
  `sermon-${route.params.slug}`,
  () => sermonStore.getPublicSermon(route.params.slug as string),
);

const notFound = computed(() => !!error.value || (!publicLoading.value && !publicSermon.value));

const safeNotes = computed(() => {
  if (!publicSermon.value?.notes) return "";
  if (import.meta.client) return DOMPurify.sanitize(publicSermon.value.notes);
  return publicSermon.value.notes;
});

useHead(() => ({
  title: publicSermon.value?.title ?? "Sermon",
  meta: publicSermon.value?.description
    ? [{ name: "description", content: publicSermon.value.description }]
    : [],
}));

const formatDate = (d: string) =>
  d ? new Date(d).toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" }) : "";

const embedUrl = computed(() => {
  const v = publicSermon.value?.video;
  if (!v) return null;
  const yt = v.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&?/]+)/);
  if (yt) return `https://www.youtube.com/embed/${yt[1]}`;
  const vimeo = v.match(/vimeo\.com\/(\d+)/);
  if (vimeo) return `https://player.vimeo.com/video/${vimeo[1]}`;
  return null;
});
</script>

<template>
  <div>
    <!-- Loading -->
    <div v-if="publicLoading" class="max-w-2xl mx-auto px-4 py-16 animate-pulse space-y-6">
      <div class="aspect-video bg-gray-100 dark:bg-gray-800 rounded" />
      <div class="h-8 bg-gray-100 dark:bg-gray-800 rounded w-3/4" />
      <div class="h-4 bg-gray-100 dark:bg-gray-800 rounded w-1/3" />
      <div class="space-y-3">
        <div v-for="i in 4" :key="i" class="h-4 bg-gray-100 dark:bg-gray-800 rounded" />
      </div>
    </div>

    <!-- Not found -->
    <div v-else-if="notFound" class="max-w-2xl mx-auto px-4 py-32 text-center">
      <p class="text-gray-400">This sermon doesn't exist.</p>
      <NuxtLink to="/sermons" class="text-sm text-gray-400 hover:text-gray-600 underline mt-2 inline-block">
        Back to Sermons
      </NuxtLink>
    </div>

    <template v-else-if="publicSermon">
      <!-- Video -->
      <div v-if="publicSermon.video" class="w-full bg-black">
        <div class="max-w-4xl mx-auto aspect-video">
          <iframe v-if="embedUrl" :src="embedUrl" class="w-full h-full" allowfullscreen allow="autoplay; encrypted-media" />
          <video v-else :src="publicSermon.video" controls class="w-full h-full" :poster="publicSermon.thumbnail" />
        </div>
      </div>
      <!-- Thumbnail fallback -->
      <div v-else-if="publicSermon.thumbnail" class="w-full bg-black max-h-[420px] overflow-hidden">
        <img :src="publicSermon.thumbnail" :alt="publicSermon.title" class="w-full max-h-[420px] object-cover opacity-90" />
      </div>

      <!-- Content -->
      <div class="max-w-2xl mx-auto px-4 py-12">
        <!-- Series -->
        <NuxtLink
          v-if="publicSermon.series"
          to="/sermons"
          class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors mb-4 inline-block"
        >
          ← {{ publicSermon.series.name }}
        </NuxtLink>
        <NuxtLink
          v-else
          to="/sermons"
          class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors mb-4 inline-block"
        >
          ← All Sermons
        </NuxtLink>

        <!-- Title -->
        <h1 class="text-3xl sm:text-4xl font-bold leading-tight text-gray-900 dark:text-white mt-3 mb-4">
          {{ publicSermon.title }}
        </h1>

        <!-- Meta row -->
        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500 dark:text-gray-400 py-4 border-y border-gray-100 dark:border-gray-800 mb-8">
          <span v-if="publicSermon.speaker">{{ publicSermon.speaker }}</span>
          <span v-if="publicSermon.scripture_reference" class="flex items-center gap-1.5">
            <UIcon name="i-lucide-book-open" class="w-3.5 h-3.5" />{{ publicSermon.scripture_reference }}
          </span>
          <span>{{ formatDate(publicSermon.sermon_date) }}</span>
        </div>

        <!-- Audio -->
        <div v-if="publicSermon.audio" class="mb-8">
          <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-2">Audio</p>
          <audio :src="publicSermon.audio" controls class="w-full" />
        </div>

        <!-- Description -->
        <p v-if="publicSermon.description" class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-8">
          {{ publicSermon.description }}
        </p>

        <!-- Notes -->
        <div v-if="publicSermon.notes">
          <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-4">Sermon Notes</p>
          <div
            class="prose prose-gray dark:prose-invert max-w-none
                   prose-p:leading-8 prose-p:text-gray-700 dark:prose-p:text-gray-300
                   prose-headings:font-bold
                   prose-a:text-gray-900 dark:prose-a:text-white prose-a:underline prose-a:underline-offset-2
                   prose-blockquote:border-l-2 prose-blockquote:border-gray-300 dark:prose-blockquote:border-gray-600 prose-blockquote:not-italic"
            v-html="safeNotes"
          />
        </div>

        <!-- Footer -->
        <div class="mt-16 pt-6 border-t border-gray-100 dark:border-gray-800">
          <NuxtLink
            to="/sermons"
            class="text-sm text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors"
          >
            ← More sermons
          </NuxtLink>
        </div>
      </div>
    </template>
  </div>
</template>
