<script setup lang="ts">
import { END_POINTS } from "~/constants/api";
import { api } from "~/services/axios";

definePageMeta({ layout: "dashboard", middleware: "dashboard" });

const authStore = useAuthStore();

const { data: overview } = await useAsyncData(
  "dashboard-overview",
  async () => {
    const res = await api.get<{
      data: { blogs: number; sermons: number; events: number; users: number };
    }>(END_POINTS.DASHBOARD.OVERVIEW);
    return res.data.data;
  },
);

const stats = computed(() => [
  {
    label: "Blogs",
    value: overview.value?.blogs ?? 0,
    icon: "i-lucide-book-open",
    to: "/dashboard/blogs",
    color: "text-blue-500",
    bg: "bg-blue-50 dark:bg-blue-900/20",
  },
  {
    label: "Sermons",
    value: overview.value?.sermons ?? 0,
    icon: "i-lucide-mic",
    to: "/dashboard/sermons",
    color: "text-purple-500",
    bg: "bg-purple-50 dark:bg-purple-900/20",
  },
  {
    label: "Events",
    value: overview.value?.events ?? 0,
    icon: "i-lucide-calendar-days",
    to: "/dashboard/events",
    color: "text-emerald-500",
    bg: "bg-emerald-50 dark:bg-emerald-900/20",
  },
  {
    label: "Users",
    value: overview.value?.users ?? 0,
    icon: "i-lucide-users",
    to: "/dashboard/users",
    color: "text-amber-500",
    bg: "bg-amber-50 dark:bg-amber-900/20",
  },
]);

const quickActions = [
  {
    label: "New Blog Post",
    description: "Write and publish an article",
    icon: "i-lucide-file-pen",
    to: "/dashboard/blogs/create",
    color: "text-blue-500",
    bg: "bg-blue-50 dark:bg-blue-900/20",
  },
  {
    label: "New Sermon",
    description: "Upload a sermon recording",
    icon: "i-lucide-mic",
    to: "/dashboard/sermons/create",
    color: "text-purple-500",
    bg: "bg-purple-50 dark:bg-purple-900/20",
  },
  {
    label: "New Event",
    description: "Schedule an upcoming event",
    icon: "i-lucide-calendar-plus",
    to: "/dashboard/events/create",
    color: "text-emerald-500",
    bg: "bg-emerald-50 dark:bg-emerald-900/20",
  },
  {
    label: "Site Settings",
    description: "Edit public page content",
    icon: "i-lucide-settings-2",
    to: "/dashboard/settings/site",
    color: "text-amber-500",
    bg: "bg-amber-50 dark:bg-amber-900/20",
  },
];

const greeting = computed(() => {
  const h = new Date().getHours();
  if (h < 12) return "Good morning";
  if (h < 17) return "Good afternoon";
  return "Good evening";
});
</script>

<template>
  <div class="px-6 py-8 space-y-8">
    <div>
      <p class="text-sm text-muted mb-1">{{ greeting }},</p>
      <h1
        class="text-3xl font-medium text-highlighted"
        style="
          font-family: &quot;Cormorant Garamond&quot;, serif;
          letter-spacing: -0.01em;
        "
      >
        {{ authStore.user?.name ?? "Welcome back" }}
      </h1>
      <p class="text-sm text-muted mt-1">
        Here's an overview of your church content.
      </p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <NuxtLink
        v-for="stat in stats"
        :key="stat.label"
        :to="stat.to"
        class="group rounded-xl border border-default bg-white dark:bg-gray-900 p-5 hover:border-gray-300 dark:hover:border-gray-700 transition-all hover:shadow-sm"
      >
        <div class="flex items-start justify-between mb-3">
          <div
            :class="[
              stat.bg,
              'w-9 h-9 rounded-lg flex items-center justify-center shrink-0',
            ]"
          >
            <UIcon :name="stat.icon" class="w-4.5 h-4.5" :class="stat.color" />
          </div>
        </div>
        <p
          class="text-3xl font-semibold text-highlighted mb-0.5"
          style="font-family: &quot;Cormorant Garamond&quot;, serif"
        >
          {{ stat.value }}
        </p>
        <p class="text-sm text-muted">{{ stat.label }}</p>
      </NuxtLink>
    </div>

    <div>
      <p class="text-xs font-semibold text-muted uppercase tracking-wider mb-3">
        Quick Actions
      </p>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <NuxtLink
          v-for="action in quickActions"
          :key="action.label"
          :to="action.to"
          class="flex items-center gap-4 rounded-xl border border-dashed border-default p-4 hover:border-gray-400 dark:hover:border-gray-600 transition-colors group"
        >
          <div
            :class="[
              action.bg,
              'w-10 h-10 rounded-lg flex items-center justify-center shrink-0',
            ]"
          >
            <UIcon :name="action.icon" class="w-5 h-5" :class="action.color" />
          </div>
          <div>
            <p class="text-sm font-semibold text-highlighted">
              {{ action.label }}
            </p>
            <p class="text-xs text-muted">{{ action.description }}</p>
          </div>
          <UIcon
            name="i-lucide-arrow-right"
            class="w-4 h-4 text-muted ml-auto opacity-0 group-hover:opacity-100 transition-opacity"
          />
        </NuxtLink>
      </div>
    </div>
  </div>
</template>
