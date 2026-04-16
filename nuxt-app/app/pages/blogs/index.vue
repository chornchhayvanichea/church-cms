<script setup lang="ts">
const blogStore = useBlogStore();
const { publicBlogs, publicMeta, publicLoading } = storeToRefs(blogStore);

const search = ref("");
const page = ref(1);

const { refresh } = await useAsyncData("public-blogs", () =>
  blogStore.getPublicBlogs({ page: page.value }),
);

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
const second = computed(() => publicBlogs.value[1] ?? null);
const rest = computed(() => publicBlogs.value.slice(2));

const formatDate = (d: string) =>
  d ? new Date(d).toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" }) : "";
</script>

<template>
  <div>
    <!-- Page header -->
    <div class="border-b border-gray-100 dark:border-gray-800">
      <UContainer class="max-w-7xl py-14">
        <div class="flex items-end justify-between gap-4">
          <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-stone-400 dark:text-stone-500 mb-2">
              From our community
            </p>
            <h1 class="text-5xl sm:text-6xl font-bold tracking-tight text-gray-900 dark:text-white leading-none">
              Blog
            </h1>
          </div>
          <UInput
            v-model="search"
            icon="i-lucide-search"
            placeholder="Search articles..."
            size="sm"
            variant="soft"
            class="w-48 mb-1"
          />
        </div>
      </UContainer>
    </div>

    <UContainer class="max-w-7xl py-16">
      <!-- Loading -->
      <div v-if="publicLoading" class="grid grid-cols-1 lg:grid-cols-2 gap-16">
        <div class="animate-pulse space-y-8">
          <div class="space-y-4">
            <div class="w-full h-72 bg-gray-100 dark:bg-gray-800 rounded-lg" />
            <div class="h-3 bg-gray-100 dark:bg-gray-800 rounded w-32" />
            <div class="h-8 bg-gray-100 dark:bg-gray-800 rounded w-full" />
            <div class="h-4 bg-gray-100 dark:bg-gray-800 rounded w-3/4" />
          </div>
          <div class="space-y-4 pt-8 border-t border-gray-100 dark:border-gray-800">
            <div class="w-full h-48 bg-gray-100 dark:bg-gray-800 rounded-lg" />
            <div class="h-3 bg-gray-100 dark:bg-gray-800 rounded w-32" />
            <div class="h-6 bg-gray-100 dark:bg-gray-800 rounded w-full" />
            <div class="h-4 bg-gray-100 dark:bg-gray-800 rounded w-2/3" />
          </div>
        </div>
        <div class="flex flex-col gap-8">
          <div v-for="i in 5" :key="i" class="grid grid-cols-5 gap-5 items-center animate-pulse">
            <div class="col-span-2 aspect-video bg-gray-100 dark:bg-gray-800 rounded-lg" />
            <div class="col-span-3 space-y-2">
              <div class="h-3 bg-gray-100 dark:bg-gray-800 rounded w-24" />
              <div class="h-5 bg-gray-100 dark:bg-gray-800 rounded w-full" />
              <div class="h-4 bg-gray-100 dark:bg-gray-800 rounded w-5/6" />
            </div>
          </div>
        </div>
      </div>

      <!-- Empty -->
      <div v-else-if="publicBlogs.length === 0" class="py-24 text-center text-gray-400">
        <p>No articles yet.</p>
      </div>

      <!-- Two-column layout -->
      <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-16">

        <!-- LEFT column: featured + second article -->
        <div class="flex flex-col gap-10">
          <!-- Featured -->
          <NuxtLink
            v-if="featured"
            :to="`/blogs/${featured.slug}`"
            class="group flex flex-col"
          >
            <div class="overflow-hidden rounded-lg w-full h-72 bg-gray-100 dark:bg-gray-800">
              <img
                v-if="featured.thumbnail"
                :src="featured.thumbnail"
                :alt="featured.title"
                class="w-full h-full object-cover group-hover:scale-[101%] transition-transform ease-in duration-200"
              />
              <div v-else class="w-full h-full bg-gray-100 dark:bg-gray-800" />
            </div>
            <div class="mt-5">
              <div class="flex items-center gap-2 text-xs text-stone-400 dark:text-stone-500 mb-3">
                <span>{{ featured.author?.name }}</span>
                <span>&bull;</span>
                <span>{{ formatDate(featured.published_at) }}</span>
              </div>
              <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors leading-snug mb-3">
                {{ featured.title }}
              </h2>
              <p v-if="featured.excerpt" class="text-stone-500 dark:text-stone-400 leading-relaxed line-clamp-3 text-sm">
                {{ featured.excerpt }}
              </p>
            </div>
          </NuxtLink>

          <!-- Second article -->
          <NuxtLink
            v-if="second"
            :to="`/blogs/${second.slug}`"
            class="group flex flex-col pt-10 border-t border-gray-100 dark:border-gray-800"
          >
            <div class="overflow-hidden rounded-lg w-full h-48 bg-gray-100 dark:bg-gray-800">
              <img
                v-if="second.thumbnail"
                :src="second.thumbnail"
                :alt="second.title"
                class="w-full h-full object-cover group-hover:scale-[101%] transition-transform ease-in duration-200"
              />
              <div v-else class="w-full h-full bg-gray-100 dark:bg-gray-800" />
            </div>
            <div class="mt-4">
              <div class="flex items-center gap-2 text-xs text-stone-400 dark:text-stone-500 mb-2">
                <span>{{ second.author?.name }}</span>
                <span>&bull;</span>
                <span>{{ formatDate(second.published_at) }}</span>
              </div>
              <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors leading-snug mb-1">
                {{ second.title }}
              </h3>
              <p v-if="second.excerpt" class="text-stone-500 dark:text-stone-400 text-sm line-clamp-2">
                {{ second.excerpt }}
              </p>
            </div>
          </NuxtLink>
        </div>

        <!-- RIGHT column: compact article list -->
        <div class="flex flex-col gap-8">
          <NuxtLink
            v-for="blog in rest"
            :key="blog.id"
            :to="`/blogs/${blog.slug}`"
            class="group grid grid-cols-5 gap-5 items-start"
          >
            <div class="col-span-2 aspect-video overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800">
              <img
                v-if="blog.thumbnail"
                :src="blog.thumbnail"
                :alt="blog.title"
                class="w-full h-full object-cover group-hover:scale-[101%] transition-transform ease-in duration-200"
              />
              <div v-else class="w-full h-full bg-gray-100 dark:bg-gray-800" />
            </div>
            <div class="col-span-3">
              <div class="flex items-center gap-2 text-xs text-stone-400 dark:text-stone-500 mb-1.5">
                <span>{{ blog.author?.name }}</span>
                <span>&bull;</span>
                <span>{{ formatDate(blog.published_at) }}</span>
              </div>
              <h3 class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors leading-snug mb-1">
                {{ blog.title }}
              </h3>
              <p v-if="blog.excerpt" class="text-stone-500 dark:text-stone-400 text-sm line-clamp-2">
                {{ blog.excerpt }}
              </p>
            </div>
          </NuxtLink>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="publicMeta.last_page > 1" class="flex justify-center mt-16">
        <UPagination v-model:page="page" :total="publicMeta.total" :items-per-page="publicMeta.per_page" />
      </div>
    </UContainer>
  </div>
</template>
