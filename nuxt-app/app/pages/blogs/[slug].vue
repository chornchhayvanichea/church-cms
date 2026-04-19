<script setup lang="ts">
import DOMPurify from "dompurify";

const route = useRoute();
const blogStore = useBlogStore();
const { publicBlog, publicBlogs, publicLoading } = storeToRefs(blogStore);

const { error } = await useAsyncData(`blog-${route.params.slug}`, () =>
  blogStore.getPublicBlog(route.params.slug as string),
);

await useAsyncData("blog-detail-related", () =>
  blogStore.getPublicBlogs({ page: 1 }),
);

const notFound = computed(
  () => !!error.value || (!publicLoading.value && !publicBlog.value),
);

const safeContent = computed(() => {
  if (!publicBlog.value?.content) return "";
  if (import.meta.client) return DOMPurify.sanitize(publicBlog.value.content);
  return publicBlog.value.content;
});

const relatedBlogs = computed(() =>
  publicBlogs.value.filter((b) => b.slug !== route.params.slug).slice(0, 3),
);

const readTime = computed(() => {
  if (!publicBlog.value?.content) return "1 min read";
  const words = publicBlog.value.content
    .replace(/<[^>]+>/g, "")
    .split(/\s+/)
    .filter(Boolean).length;
  return `${Math.max(1, Math.ceil(words / 200))} min read`;
});

useHead(() => ({
  title: publicBlog.value?.title ?? "Article",
  meta: publicBlog.value?.excerpt
    ? [{ name: "description", content: publicBlog.value.excerpt }]
    : [],
}));

const formatDate = (d: string) =>
  d
    ? new Date(d).toLocaleDateString("en-US", {
        month: "long",
        day: "numeric",
        year: "numeric",
      })
    : "";
</script>

<template>
  <div>
    <!-- Loading -->
    <div
      v-if="publicLoading"
      class="max-w-3xl mx-auto px-4 py-16 animate-pulse space-y-6"
    >
      <div class="h-4 bg-gray-100 dark:bg-gray-800 rounded w-28" />
      <div class="h-10 bg-gray-100 dark:bg-gray-800 rounded w-3/4" />
      <div class="h-7 bg-gray-100 dark:bg-gray-800 rounded w-1/2" />
      <div class="flex items-center gap-3">
        <div
          class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 shrink-0"
        />
        <div class="space-y-1.5">
          <div class="h-3.5 bg-gray-100 dark:bg-gray-800 rounded w-32" />
          <div class="h-3 bg-gray-100 dark:bg-gray-800 rounded w-24" />
        </div>
      </div>
      <div class="h-80 bg-gray-100 dark:bg-gray-800 rounded-2xl" />
      <div class="space-y-3 pt-4">
        <div
          v-for="i in 8"
          :key="i"
          class="h-4 bg-gray-100 dark:bg-gray-800 rounded"
          :class="i % 4 === 0 ? 'w-3/4' : 'w-full'"
        />
      </div>
    </div>

    <!-- Not found -->
    <div v-else-if="notFound" class="max-w-2xl mx-auto px-4 py-32 text-center">
      <UIcon
        name="i-lucide-file-x"
        class="w-12 h-12 text-gray-200 dark:text-gray-700 mx-auto mb-4"
      />
      <p class="text-gray-600 dark:text-gray-400 font-medium mb-1">
        Article not found
      </p>
      <p class="text-gray-400 text-sm mb-8">
        This article doesn't exist or may have been removed.
      </p>
      <NuxtLink
        to="/blogs"
        class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors"
      >
        <UIcon name="i-lucide-arrow-left" class="w-4 h-4" />
        Back to Blog
      </NuxtLink>
    </div>

    <div v-else-if="publicBlog">
      <!-- Article header -->
      <div class="border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-3xl mx-auto px-4 pt-24 pb-10">
          <!-- Back link -->
          <NuxtLink
            to="/blogs"
            class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors mb-10 group"
          >
            <UIcon
              name="i-lucide-arrow-left"
              class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform"
            />
            All articles
          </NuxtLink>

          <!-- Title -->
          <h1
            class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight text-gray-900 dark:text-white mb-5"
          >
            {{ publicBlog.title }}
          </h1>

          <!-- Excerpt -->
          <p
            v-if="publicBlog.excerpt"
            class="text-xl text-gray-500 dark:text-gray-400 leading-relaxed mb-8"
          >
            {{ publicBlog.excerpt }}
          </p>

          <!-- Byline -->
          <div class="flex items-center gap-3">
            <div
              class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden shrink-0 flex items-center justify-center"
            >
              <img
                v-if="publicBlog.author?.avatar"
                :src="publicBlog.author.avatar"
                :alt="publicBlog.author.name"
                class="w-full h-full object-cover"
              />
              <UIcon
                v-else
                name="i-lucide-user"
                class="w-4 h-4 text-gray-400"
              />
            </div>
            <div>
              <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                {{ publicBlog.author?.name }}
              </p>
              <div
                class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mt-0.5"
              >
                <span>{{ formatDate(publicBlog.published_at) }}</span>
                <span
                  class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"
                />
                <span>{{ readTime }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Hero image (wider than article) -->
      <div v-if="publicBlog.thumbnail" class="bg-gray-50 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto px-4 py-10">
          <img
            :src="publicBlog.thumbnail"
            :alt="publicBlog.title"
            class="w-full max-h-[540px] object-cover rounded-2xl"
          />
        </div>
      </div>

      <!-- Content -->
      <article class="max-w-2xl mx-auto px-4 py-12 sm:py-16">
        <div
          class="prose prose-gray dark:prose-invert max-w-none prose-p:leading-8 prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-headings:font-bold prose-headings:tracking-tight prose-img:rounded-xl prose-img:w-full prose-a:text-gray-900 dark:prose-a:text-white prose-a:underline prose-a:underline-offset-2 prose-blockquote:border-l-[3px] prose-blockquote:border-amber-400 prose-blockquote:not-italic prose-blockquote:pl-5 prose-blockquote:pr-4 prose-blockquote:text-gray-600 dark:prose-blockquote:text-gray-400"
          v-html="safeContent"
        />
      </article>

      <!-- More articles -->
      <div
        v-if="relatedBlogs.length > 0"
        class="border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900"
      >
        <UContainer class="max-w-5xl py-16">
          <div class="flex items-center justify-between mb-10">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
              More Articles
            </h2>
            <NuxtLink
              to="/blogs"
              class="text-sm text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors"
            >
              View all →
            </NuxtLink>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <NuxtLink
              v-for="blog in relatedBlogs"
              :key="blog.id"
              :to="`/blogs/${blog.slug}`"
              class="group flex flex-col"
            >
              <div
                class="overflow-hidden rounded-xl w-full aspect-video bg-gray-100 dark:bg-gray-800 mb-4"
              >
                <img
                  v-if="blog.thumbnail"
                  :src="blog.thumbnail"
                  :alt="blog.title"
                  class="w-full h-full object-cover group-hover:scale-[102%] transition-transform duration-500 ease-out"
                />
                <div
                  v-else
                  class="w-full h-full flex items-center justify-center"
                >
                  <UIcon
                    name="i-lucide-image"
                    class="w-8 h-8 text-gray-300 dark:text-gray-600"
                  />
                </div>
              </div>
              <div
                class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-2"
              >
                <span>{{ blog.author?.name }}</span>
                <span
                  class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"
                />
                <span>{{ formatDate(blog.published_at) }}</span>
              </div>
              <h3
                class="text-base font-bold text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors leading-snug"
              >
                {{ blog.title }}
              </h3>
              <p
                v-if="blog.excerpt"
                class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2 mt-1.5 leading-relaxed"
              >
                {{ blog.excerpt }}
              </p>
            </NuxtLink>
          </div>
        </UContainer>
      </div>
    </div>
  </div>
</template>
