<script setup lang="ts">
import { publicSearchApi, type PublicSearchResults } from "~/services/search";

const route = useRoute();
const scrolled = ref(false);
const mobileOpen = ref(false);
const searchOpen = ref(false);
const searchQuery = ref("");
const searchLoading = ref(false);
const searchResults = ref<PublicSearchResults>({ sermons: [], blogs: [], events: [] });
const searchInput = ref<HTMLInputElement | null>(null);

const navItems = [
  { label: "Home", to: "/" },
  { label: "About", to: "/about" },
  { label: "Sermons", to: "/sermons" },
  { label: "Events", to: "/events" },
  { label: "Blog", to: "/blogs" },
  { label: "Contact", to: "/contact" },
];

const isActive = (to: string) =>
  to === "/" ? route.path === "/" : route.path.startsWith(to);

const hasResults = computed(
  () =>
    searchResults.value.sermons.length > 0 ||
    searchResults.value.blogs.length > 0 ||
    searchResults.value.events.length > 0,
);

const showEmpty = computed(
  () => searchQuery.value.length >= 2 && !searchLoading.value && !hasResults.value,
);

let searchTimer: ReturnType<typeof setTimeout>;
watch(searchQuery, (q) => {
  clearTimeout(searchTimer);
  if (q.length < 2) {
    searchResults.value = { sermons: [], blogs: [], events: [] };
    return;
  }
  searchLoading.value = true;
  searchTimer = setTimeout(async () => {
    try {
      const res = await publicSearchApi(q);
      searchResults.value = res.data;
    } catch {
      searchResults.value = { sermons: [], blogs: [], events: [] };
    } finally {
      searchLoading.value = false;
    }
  }, 300);
});

const openSearch = () => {
  searchOpen.value = true;
  nextTick(() => searchInput.value?.focus());
};

const closeSearch = () => {
  searchOpen.value = false;
  searchQuery.value = "";
  searchResults.value = { sermons: [], blogs: [], events: [] };
};

const navigateResult = (to: string) => {
  closeSearch();
  navigateTo(to);
};

onMounted(() => {
  const onScroll = () => { scrolled.value = window.scrollY > 30; };
  window.addEventListener("scroll", onScroll, { passive: true });
  onUnmounted(() => window.removeEventListener("scroll", onScroll));

  const onKey = (e: KeyboardEvent) => {
    if ((e.metaKey || e.ctrlKey) && e.key === "k") {
      e.preventDefault();
      searchOpen.value ? closeSearch() : openSearch();
    }
    if (e.key === "Escape") closeSearch();
  };
  window.addEventListener("keydown", onKey);
  onUnmounted(() => window.removeEventListener("keydown", onKey));
});

watch(() => route.path, () => {
  mobileOpen.value = false;
  closeSearch();
});
</script>

<template>
  <header
    class="fixed top-0 inset-x-0 z-50 transition-all duration-300"
    :class="scrolled
      ? 'bg-white/95 dark:bg-[#0c0c0c]/95 backdrop-blur-md border-b border-gray-100 dark:border-white/8'
      : 'bg-transparent'"
  >
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
      <div class="flex items-center justify-between h-16 sm:h-18">

        <!-- Logo + name -->
        <NuxtLink to="/" class="flex items-center gap-3 shrink-0">
          <div
            class="p-1.5 rounded-lg transition-colors"
            :class="scrolled ? 'bg-[#0c0c0c] dark:bg-white' : 'bg-white/15 backdrop-blur-sm'"
          >
            <LogoComponent class="h-5 w-auto" />
          </div>
          <span
            class="text-lg font-medium leading-none transition-colors hidden sm:block"
            :class="scrolled ? 'text-gray-900 dark:text-white' : 'text-white'"
            style="font-family: 'Cormorant Garamond', serif; letter-spacing: 0.01em;"
          >
            Grace Church
          </span>
        </NuxtLink>

        <!-- Desktop nav -->
        <nav class="hidden md:flex items-center gap-1">
          <NuxtLink
            v-for="item in navItems"
            :key="item.to"
            :to="item.to"
            class="relative px-3.5 py-1.5 text-sm font-medium tracking-wide transition-colors rounded-md"
            :class="[
              isActive(item.to)
                ? scrolled ? 'text-gray-900 dark:text-white' : 'text-white'
                : scrolled ? 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' : 'text-white/70 hover:text-white',
            ]"
          >
            {{ item.label }}
            <span
              v-if="isActive(item.to)"
              class="absolute bottom-0 left-3.5 right-3.5 h-px rounded-full transition-colors"
              :class="scrolled ? 'bg-gray-900 dark:bg-white' : 'bg-white'"
            />
          </NuxtLink>
        </nav>

        <!-- Right actions -->
        <div class="flex items-center gap-2">
          <!-- Search button -->
          <button
            class="p-2 rounded-md transition-colors"
            :class="scrolled ? 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' : 'text-white/70 hover:text-white'"
            aria-label="Search"
            @click="openSearch"
          >
            <UIcon name="i-lucide-search" class="w-4 h-4" />
          </button>

          <NuxtLink
            to="/donate"
            class="hidden md:inline-flex items-center gap-1.5 px-4 py-1.5 text-sm font-medium rounded-full border transition-all"
            :class="scrolled
              ? 'border-gray-900 dark:border-white text-gray-900 dark:text-white hover:bg-gray-900 hover:text-white dark:hover:bg-white dark:hover:text-gray-900'
              : 'border-white/70 text-white hover:bg-white/15'"
          >
            Donate
          </NuxtLink>

          <!-- Mobile hamburger -->
          <button
            class="md:hidden p-2 rounded-md transition-colors"
            :class="scrolled ? 'text-gray-700 dark:text-gray-300' : 'text-white'"
            @click="mobileOpen = !mobileOpen"
          >
            <UIcon :name="mobileOpen ? 'i-lucide-x' : 'i-lucide-menu'" class="w-5 h-5" />
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <Transition
      enter-active-class="transition-all duration-200 ease-out"
      enter-from-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition-all duration-150 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-2"
    >
      <div
        v-if="mobileOpen"
        class="md:hidden bg-white dark:bg-[#0c0c0c] border-b border-gray-100 dark:border-white/8"
      >
        <nav class="max-w-7xl mx-auto px-5 py-4 flex flex-col gap-1">
          <NuxtLink
            v-for="item in navItems"
            :key="item.to"
            :to="item.to"
            class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"
            :class="isActive(item.to)
              ? 'bg-gray-100 dark:bg-white/8 text-gray-900 dark:text-white'
              : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-white/5'"
          >
            {{ item.label }}
          </NuxtLink>
          <div class="pt-2 mt-1 border-t border-gray-100 dark:border-white/8">
            <NuxtLink
              to="/donate"
              class="flex items-center justify-center px-3 py-2.5 rounded-lg text-sm font-semibold bg-gray-900 dark:bg-white text-white dark:text-gray-900 transition-colors hover:bg-gray-700 dark:hover:bg-gray-100"
            >
              Donate
            </NuxtLink>
          </div>
        </nav>
      </div>
    </Transition>
  </header>

  <!-- Search overlay -->
  <Teleport to="body">
    <Transition
      enter-active-class="transition-all duration-150 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-all duration-100 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="searchOpen"
        class="fixed inset-0 z-[200] flex items-start justify-center pt-[12vh] px-4"
        @click.self="closeSearch"
      >
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeSearch" />

        <!-- Search card -->
        <Transition
          enter-active-class="transition-all duration-150 ease-out"
          enter-from-class="opacity-0 scale-95 -translate-y-2"
          enter-to-class="opacity-100 scale-100 translate-y-0"
          appear
        >
          <div class="relative w-full max-w-2xl bg-white dark:bg-gray-900 rounded-2xl shadow-2xl overflow-hidden">
            <!-- Input -->
            <div class="flex items-center gap-3 px-4 py-4 border-b border-gray-100 dark:border-white/8">
              <UIcon
                v-if="!searchLoading"
                name="i-lucide-search"
                class="w-5 h-5 text-gray-400 shrink-0"
              />
              <UIcon
                v-else
                name="i-lucide-loader"
                class="w-5 h-5 text-gray-400 shrink-0 animate-spin"
              />
              <input
                ref="searchInput"
                v-model="searchQuery"
                type="text"
                placeholder="Search sermons, blogs, events…"
                class="flex-1 bg-transparent text-gray-900 dark:text-white placeholder-gray-400 text-sm outline-none"
              />
              <button
                class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 px-2 py-1 rounded border border-gray-200 dark:border-white/10 transition-colors"
                @click="closeSearch"
              >
                Esc
              </button>
            </div>

            <!-- Results -->
            <div class="max-h-[55vh] overflow-y-auto">
              <!-- Sermons -->
              <div v-if="searchResults.sermons.length" class="p-2">
                <p class="px-3 py-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Sermons</p>
                <button
                  v-for="item in searchResults.sermons"
                  :key="item.slug"
                  class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5 transition-colors text-left"
                  @click="navigateResult(`/sermons/${item.slug}`)"
                >
                  <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center shrink-0">
                    <UIcon name="i-lucide-mic" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                  </div>
                  <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ item.title }}</p>
                    <p v-if="item.subtitle" class="text-xs text-gray-500 truncate">{{ item.subtitle }}</p>
                  </div>
                </button>
              </div>

              <!-- Blogs -->
              <div v-if="searchResults.blogs.length" class="p-2" :class="{ 'border-t border-gray-100 dark:border-white/8': searchResults.sermons.length }">
                <p class="px-3 py-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Blog</p>
                <button
                  v-for="item in searchResults.blogs"
                  :key="item.slug"
                  class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5 transition-colors text-left"
                  @click="navigateResult(`/blogs/${item.slug}`)"
                >
                  <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center shrink-0">
                    <UIcon name="i-lucide-book" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                  </div>
                  <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ item.title }}</p>
                    <p v-if="item.subtitle" class="text-xs text-gray-500 truncate">{{ item.subtitle }}</p>
                  </div>
                </button>
              </div>

              <!-- Events -->
              <div v-if="searchResults.events.length" class="p-2" :class="{ 'border-t border-gray-100 dark:border-white/8': searchResults.sermons.length || searchResults.blogs.length }">
                <p class="px-3 py-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Events</p>
                <button
                  v-for="(item, i) in searchResults.events"
                  :key="i"
                  class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5 transition-colors text-left"
                  @click="navigateResult('/events')"
                >
                  <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center shrink-0">
                    <UIcon name="i-lucide-calendar-days" class="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                  </div>
                  <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ item.title }}</p>
                    <p v-if="item.subtitle" class="text-xs text-gray-500 truncate">{{ item.subtitle }}</p>
                  </div>
                </button>
              </div>

              <!-- Empty state -->
              <div v-if="showEmpty" class="flex flex-col items-center gap-2 py-12 text-gray-400">
                <UIcon name="i-lucide-search-x" class="w-8 h-8" />
                <p class="text-sm">No results for <span class="font-medium text-gray-600 dark:text-gray-300">"{{ searchQuery }}"</span></p>
              </div>

              <!-- Initial hint -->
              <div v-if="!searchQuery" class="flex flex-col items-center gap-2 py-10 text-gray-400">
                <UIcon name="i-lucide-search" class="w-7 h-7" />
                <p class="text-sm">Type to search sermons, blogs, and events</p>
                <p class="text-xs">Press <kbd class="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-400 font-mono">⌘K</kbd> to open anytime</p>
              </div>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>
