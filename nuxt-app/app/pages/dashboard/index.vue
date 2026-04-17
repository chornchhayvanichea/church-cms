<script setup lang="ts">
import { END_POINTS } from "~/constants/api";
import { api } from "~/services/axios";

definePageMeta({ layout: "dashboard", middleware: "dashboard" });

const { data: overview } = await useAsyncData("dashboard-overview", async () => {
  const res = await api.get<{ data: { blogs: number; sermons: number; events: number; users: number } }>(END_POINTS.DASHBOARD.OVERVIEW);
  return res.data.data;
});

const stats = computed(() => [
  { label: "Blogs", value: overview.value?.blogs ?? 0, icon: "i-lucide-book-open", to: "/dashboard/blogs", color: "text-blue-500" },
  { label: "Sermons", value: overview.value?.sermons ?? 0, icon: "i-lucide-mic", to: "/dashboard/sermons", color: "text-purple-500" },
  { label: "Events", value: overview.value?.events ?? 0, icon: "i-lucide-calendar-days", to: "/dashboard/events", color: "text-green-500" },
  { label: "Users", value: overview.value?.users ?? 0, icon: "i-lucide-users", to: "/dashboard/users", color: "text-amber-500" },
]);
</script>

<template>
  <div class="space-y-8">
    <div>
      <h1 class="text-xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
      <p class="text-sm text-gray-500 mt-1">Welcome back. Here's an overview of your content.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <NuxtLink
        v-for="stat in stats"
        :key="stat.label"
        :to="stat.to"
        class="group rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 hover:border-gray-300 dark:hover:border-gray-700 transition-colors"
      >
        <div class="flex items-center justify-between mb-4">
          <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ stat.label }}</span>
          <UIcon :name="stat.icon" class="w-5 h-5" :class="stat.color" />
        </div>
        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ stat.value }}</p>
      </NuxtLink>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <NuxtLink
        to="/dashboard/blogs/create"
        class="flex items-center gap-4 rounded-xl border border-dashed border-gray-200 dark:border-gray-800 p-5 hover:border-gray-400 dark:hover:border-gray-600 transition-colors group"
      >
        <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center shrink-0">
          <UIcon name="i-lucide-plus" class="w-5 h-5 text-blue-500" />
        </div>
        <div>
          <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">New Blog Post</p>
          <p class="text-xs text-gray-400">Write and publish an article</p>
        </div>
      </NuxtLink>
      <NuxtLink
        to="/dashboard/sermons/create"
        class="flex items-center gap-4 rounded-xl border border-dashed border-gray-200 dark:border-gray-800 p-5 hover:border-gray-400 dark:hover:border-gray-600 transition-colors group"
      >
        <div class="w-10 h-10 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center shrink-0">
          <UIcon name="i-lucide-plus" class="w-5 h-5 text-purple-500" />
        </div>
        <div>
          <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">New Sermon</p>
          <p class="text-xs text-gray-400">Upload a sermon recording</p>
        </div>
      </NuxtLink>
      <NuxtLink
        to="/dashboard/events/create"
        class="flex items-center gap-4 rounded-xl border border-dashed border-gray-200 dark:border-gray-800 p-5 hover:border-gray-400 dark:hover:border-gray-600 transition-colors group"
      >
        <div class="w-10 h-10 rounded-lg bg-green-50 dark:bg-green-900/20 flex items-center justify-center shrink-0">
          <UIcon name="i-lucide-plus" class="w-5 h-5 text-green-500" />
        </div>
        <div>
          <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">New Event</p>
          <p class="text-xs text-gray-400">Schedule an upcoming event</p>
        </div>
      </NuxtLink>
      <NuxtLink
        to="/dashboard/settings/site"
        class="flex items-center gap-4 rounded-xl border border-dashed border-gray-200 dark:border-gray-800 p-5 hover:border-gray-400 dark:hover:border-gray-600 transition-colors group"
      >
        <div class="w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center shrink-0">
          <UIcon name="i-lucide-settings" class="w-5 h-5 text-amber-500" />
        </div>
        <div>
          <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Site Settings</p>
          <p class="text-xs text-gray-400">Edit public page content</p>
        </div>
      </NuxtLink>
    </div>
  </div>
</template>
