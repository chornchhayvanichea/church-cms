<script setup lang="ts">
import DOMPurify from "dompurify";

const route = useRoute();
const blogStore = useBlogStore();
const { publicBlog, publicLoading } = storeToRefs(blogStore);

const { error } = await useAsyncData(
  `blog-${route.params.slug}`,
  () => blogStore.getPublicBlog(route.params.slug as string),
);

const notFound = computed(() => !!error.value || (!publicLoading.value && !publicBlog.value));

const safeContent = computed(() => {
  if (!publicBlog.value?.content) return "";
  if (import.meta.client) return DOMPurify.sanitize(publicBlog.value.content);
  return publicBlog.value.content;
});

useHead(() => ({
  title: publicBlog.value?.title ?? "Article",
  meta: publicBlog.value?.excerpt ? [{ name: "description", content: publicBlog.value.excerpt }] : [],
}));

const formatDate = (d: string) =>
  d ? new Date(d).toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" }) : "";
</script>

<template>
  <div>
    <!-- Loading -->
    <div v-if="publicLoading" class="max-w-2xl mx-auto px-4 py-16 animate-pulse space-y-6">
      <div class="h-8 bg-gray-100 dark:bg-gray-800 rounded w-3/4" />
      <div class="h-8 bg-gray-100 dark:bg-gray-800 rounded w-1/2" />
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-gray-100 dark:bg-gray-800" />
        <div class="h-4 bg-gray-100 dark:bg-gray-800 rounded w-40" />
      </div>
      <div class="h-64 bg-gray-100 dark:bg-gray-800 rounded" />
      <div class="space-y-3">
        <div v-for="i in 6" :key="i" class="h-4 bg-gray-100 dark:bg-gray-800 rounded" :class="i % 4 === 0 ? 'w-3/4' : 'w-full'" />
      </div>
    </div>

    <!-- Not found -->
    <div v-else-if="notFound" class="max-w-2xl mx-auto px-4 py-32 text-center">
      <p class="text-gray-400">This article doesn't exist.</p>
      <NuxtLink to="/blogs" class="text-sm text-gray-400 hover:text-gray-600 underline mt-2 inline-block">
        Back to Blog
      </NuxtLink>
    </div>

    <article v-else-if="publicBlog" class="max-w-2xl mx-auto px-4 py-16">
      <!-- Headline -->
      <h1 class="text-3xl sm:text-4xl font-bold leading-tight text-gray-900 dark:text-white mb-4">
        {{ publicBlog.title }}
      </h1>

      <!-- Excerpt -->
      <p v-if="publicBlog.excerpt" class="text-xl text-gray-500 dark:text-gray-400 leading-relaxed mb-6">
        {{ publicBlog.excerpt }}
      </p>

      <!-- Byline -->
      <div class="flex items-center gap-3 py-4 border-y border-gray-100 dark:border-gray-800 mb-8">
        <div class="w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden shrink-0 flex items-center justify-center">
          <img
            v-if="publicBlog.author?.avatar"
            :src="publicBlog.author.avatar"
            :alt="publicBlog.author.name"
            class="w-full h-full object-cover"
          />
          <UIcon v-else name="i-lucide-user" class="w-4 h-4 text-gray-400" />
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
          <span class="font-medium text-gray-700 dark:text-gray-300">{{ publicBlog.author?.name }}</span>
          <span>&bull;</span>
          <span>{{ formatDate(publicBlog.published_at) }}</span>
        </div>
      </div>

      <!-- Thumbnail -->
      <div v-if="publicBlog.thumbnail" class="mb-10">
        <img
          :src="publicBlog.thumbnail"
          :alt="publicBlog.title"
          class="w-full object-cover max-h-[460px]"
        />
      </div>

      <!-- Content -->
      <div
        class="prose prose-gray dark:prose-invert max-w-none
               prose-p:leading-8 prose-p:text-gray-700 dark:prose-p:text-gray-300
               prose-headings:font-bold prose-headings:tracking-tight
               prose-img:rounded prose-img:w-full
               prose-a:text-gray-900 dark:prose-a:text-white prose-a:underline prose-a:underline-offset-2
               prose-blockquote:border-l-2 prose-blockquote:border-gray-300 dark:prose-blockquote:border-gray-600 prose-blockquote:not-italic prose-blockquote:text-gray-600 dark:prose-blockquote:text-gray-400"
        v-html="safeContent"
      />

      <!-- Footer -->
      <div class="mt-16 pt-6 border-t border-gray-100 dark:border-gray-800">
        <NuxtLink
          to="/blogs"
          class="text-sm text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors"
        >
          ← More articles
        </NuxtLink>
      </div>
    </article>
  </div>
</template>
