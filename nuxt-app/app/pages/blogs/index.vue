<script setup lang="ts">
const blogStore = useBlogStore();
const { publicBlogs, publicMeta, publicLoading } = storeToRefs(blogStore);

const search = ref("");
const page = ref(1);

const [{ refresh }, { settings }] = await Promise.all([
  useAsyncData("public-blogs", () => blogStore.getPublicBlogs({ page: page.value })),
  usePublicSettings(),
]);

watch(page, () => refresh());

let searchTimer: ReturnType<typeof setTimeout>;
watch(search, () => {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    page.value = 1;
    blogStore.getPublicBlogs({ page: 1, "filter[title]": search.value || undefined });
  }, 400);
});

const featured = computed(() => publicBlogs.value[0] ?? null);
const gridBlogs = computed(() => publicBlogs.value.slice(1));

const formatDate = (d: string) =>
  d ? new Date(d).toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" }) : "";

function readTime(content?: string) {
  if (!content) return "1 min read";
  const words = content.replace(/<[^>]+>/g, "").split(/\s+/).filter(Boolean).length;
  return `${Math.max(1, Math.ceil(words / 200))} min read`;
}
</script>

<template>
  <div>
    <!-- Hero header -->
    <div class="bg-stone-50 dark:bg-stone-950 border-b border-stone-200 dark:border-stone-800">
      <UContainer class="max-w-7xl py-16 sm:py-20">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
          <div class="max-w-xl">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-600 dark:text-amber-500 mb-3">
              {{ settings.blogs_hero_label || 'From Our Community' }}
            </p>
            <h1 class="text-5xl sm:text-7xl font-bold tracking-tight text-gray-900 dark:text-white leading-none mb-4">
              {{ settings.blogs_hero_title || 'Blog' }}
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-lg leading-relaxed">
              {{ settings.blogs_hero_description || 'Thoughts, stories, and reflections from our church community.' }}
            </p>
          </div>
          <UInput
            v-model="search"
            icon="i-lucide-search"
            placeholder="Search articles..."
            size="md"
            variant="soft"
            class="w-full sm:w-56 shrink-0"
          />
        </div>
      </UContainer>
    </div>

    <UContainer class="max-w-7xl py-14 sm:py-16">
      <!-- Article count -->
      <div class="mb-10">
        <p v-if="!publicLoading && publicBlogs.length > 0" class="text-sm text-gray-400">
          {{ publicMeta.total }} article{{ publicMeta.total !== 1 ? "s" : "" }}
        </p>
        <div v-else-if="publicLoading" class="h-4 w-20 bg-gray-100 dark:bg-gray-800 rounded animate-pulse" />
      </div>

      <!-- Loading skeleton -->
      <div v-if="publicLoading" class="space-y-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center animate-pulse">
          <div class="w-full h-80 lg:h-96 bg-gray-100 dark:bg-gray-800 rounded-2xl" />
          <div class="space-y-4">
            <div class="h-6 w-24 bg-gray-100 dark:bg-gray-800 rounded-full" />
            <div class="h-10 bg-gray-100 dark:bg-gray-800 rounded w-full" />
            <div class="h-10 bg-gray-100 dark:bg-gray-800 rounded w-3/4" />
            <div class="h-5 bg-gray-100 dark:bg-gray-800 rounded w-full" />
            <div class="h-5 bg-gray-100 dark:bg-gray-800 rounded w-2/3" />
            <div class="h-4 bg-gray-100 dark:bg-gray-800 rounded w-48 mt-2" />
          </div>
        </div>
        <div class="border-t border-gray-100 dark:border-gray-800 pt-14">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div v-for="i in 3" :key="i" class="animate-pulse space-y-4">
              <div class="w-full aspect-video bg-gray-100 dark:bg-gray-800 rounded-xl" />
              <div class="h-3 bg-gray-100 dark:bg-gray-800 rounded w-28" />
              <div class="h-5 bg-gray-100 dark:bg-gray-800 rounded w-full" />
              <div class="h-4 bg-gray-100 dark:bg-gray-800 rounded w-4/5" />
            </div>
          </div>
        </div>
      </div>

      <!-- Empty state -->
      <div v-else-if="publicBlogs.length === 0" class="py-32 text-center">
        <UIcon name="i-lucide-file-text" class="w-12 h-12 text-gray-200 dark:text-gray-700 mx-auto mb-4" />
        <p class="text-gray-500 font-medium">No articles yet.</p>
        <p class="text-gray-400 text-sm mt-1">Check back soon.</p>
      </div>

      <div v-else class="space-y-16">
        <!-- Featured article -->
        <NuxtLink
          v-if="featured"
          :to="`/blogs/${featured.slug}`"
          class="group block"
        >
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-14 items-center">
            <div class="overflow-hidden rounded-2xl w-full h-72 lg:h-96 bg-gray-100 dark:bg-gray-800 shrink-0">
              <img
                v-if="featured.thumbnail"
                :src="featured.thumbnail"
                :alt="featured.title"
                class="w-full h-full object-cover group-hover:scale-[102%] transition-transform duration-500 ease-out"
              />
              <div v-else class="w-full h-full flex items-center justify-center">
                <UIcon name="i-lucide-image" class="w-10 h-10 text-gray-300 dark:text-gray-600" />
              </div>
            </div>
            <div>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-900 dark:bg-white text-white dark:text-gray-900 mb-5">
                Featured
              </span>
              <h2 class="text-3xl sm:text-4xl lg:text-[2.75rem] font-bold text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors leading-tight mb-4">
                {{ featured.title }}
              </h2>
              <p v-if="featured.excerpt" class="text-gray-500 dark:text-gray-400 leading-relaxed text-lg mb-6 line-clamp-3">
                {{ featured.excerpt }}
              </p>
              <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-gray-400 dark:text-gray-500">
                <span class="font-medium text-gray-600 dark:text-gray-400">{{ featured.author?.name }}</span>
                <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600 shrink-0" />
                <span>{{ formatDate(featured.published_at) }}</span>
                <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600 shrink-0" />
                <span>{{ readTime(featured.content) }}</span>
              </div>
              <div class="mt-7">
                <span class="inline-flex items-center gap-2 text-sm font-bold text-gray-900 dark:text-white group-hover:gap-3 transition-all duration-200">
                  Read article
                  <UIcon name="i-lucide-arrow-right" class="w-4 h-4" />
                </span>
              </div>
            </div>
          </div>
        </NuxtLink>

        <!-- Article grid -->
        <div v-if="gridBlogs.length > 0" class="border-t border-gray-100 dark:border-gray-800 pt-14">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
            <NuxtLink
              v-for="blog in gridBlogs"
              :key="blog.id"
              :to="`/blogs/${blog.slug}`"
              class="group flex flex-col"
            >
              <div class="overflow-hidden rounded-xl w-full aspect-video bg-gray-100 dark:bg-gray-800 mb-5 shrink-0">
                <img
                  v-if="blog.thumbnail"
                  :src="blog.thumbnail"
                  :alt="blog.title"
                  class="w-full h-full object-cover group-hover:scale-[102%] transition-transform duration-500 ease-out"
                />
                <div v-else class="w-full h-full flex items-center justify-center">
                  <UIcon name="i-lucide-image" class="w-8 h-8 text-gray-300 dark:text-gray-600" />
                </div>
              </div>
              <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-gray-400 dark:text-gray-500 mb-2.5">
                <span class="font-medium text-gray-500 dark:text-gray-400">{{ blog.author?.name }}</span>
                <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600 shrink-0" />
                <span>{{ formatDate(blog.published_at) }}</span>
                <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600 shrink-0" />
                <span>{{ readTime(blog.content) }}</span>
              </div>
              <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors leading-snug mb-2 flex-1">
                {{ blog.title }}
              </h3>
              <p v-if="blog.excerpt" class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2 leading-relaxed">
                {{ blog.excerpt }}
              </p>
            </NuxtLink>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="publicMeta.last_page > 1" class="flex justify-center mt-16 pt-8 border-t border-gray-100 dark:border-gray-800">
        <UPagination v-model:page="page" :total="publicMeta.total" :items-per-page="publicMeta.per_page" />
      </div>
    </UContainer>
  </div>
</template>
