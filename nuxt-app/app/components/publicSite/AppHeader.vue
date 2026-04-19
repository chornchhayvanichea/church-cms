<script setup lang="ts">
const route = useRoute();
const scrolled = ref(false);
const mobileOpen = ref(false);

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

onMounted(() => {
  const onScroll = () => { scrolled.value = window.scrollY > 30; };
  window.addEventListener("scroll", onScroll, { passive: true });
  onUnmounted(() => window.removeEventListener("scroll", onScroll));
});

watch(() => route.path, () => { mobileOpen.value = false; });
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
</template>
