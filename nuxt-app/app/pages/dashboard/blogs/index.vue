<template>
  <div class="container mx-auto px-7">
    <!-- Header -->
    <div
      class="sticky top-0 z-50 mb-12 space-y-5 -mx-5 px-5 py-9 border-b border-gray-200 dark:border-gray-800"
    >
      <div>
        <h1 class="text-4xl font-bold mb-2">Blogs Management</h1>
      </div>
      <div
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-5"
      >
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-5">
          <USelectMenu
            v-model="statusFilter"
            v-model:open="open"
            :items="statusItems"
            class="w-full sm:w-48"
            placeholder="Filter by status"
          />
          <USelectMenu
            v-model="authorFilter"
            :items="authorItems"
            class="w-full sm:w-48"
            placeholder="Filter by author"
          />
        </div>
        <div class="space-x-5 p-2">
          <UDashboardSearchButton collapsed size="md" />
          <UButton :to="DASHBOARD_ROUTES.BLOGS_CREATE" class="w-full sm:w-auto">
            <UIcon name="i-heroicons-plus" />
            New
          </UButton>
        </div>
      </div>
    </div>
    <!-- Empty State -->
    <div v-if="filteredPosts.length === 0" class="text-center py-12">
      <p class="text-gray-500 mb-4">No blog posts found</p>
      <UButton :to="DASHBOARD_ROUTES.BLOGS_CREATE"
        >Create your first blog post</UButton
      >
    </div>

    <!-- Blog Posts Grid -->
    <div
      v-else
      class="grid gap-4"
      style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))"
    >
      <div v-for="post in filteredPosts" :key="post.id" class="relative group">
        <UBlogPost
          :title="post.title"
          :description="post.description"
          :image="post.image"
          :date="post.date"
          :authors="post.authors"
          variant="subtle"
          :ui="{
            title: 'text-md',
            description: 'text-sm',
          }"
        />
        <!-- Action buttons on hover -->
        <div
          class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex gap-2"
        >
          <UButton
            icon="i-heroicons-pencil"
            color="primary"
            variant="ghost"
            size="sm"
            :to="`/dashboard/blogs/${post.id}/edit`"
          />
          <UButton
            icon="i-heroicons-trash"
            color="primary"
            variant="ghost"
            size="sm"
            @click="deletePost(post.id)"
          />
        </div>
      </div>
    </div>
    <div class="flex justify-center mt-8">
      <UPagination v-model:page="page" :total="100" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { DASHBOARD_ROUTES } from "~/constants/routes";

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});

const open = ref(false);
const statusFilter = ref("All");
const authorFilter = ref("All");

const statusItems = ref(["All", "Draft", "Published", "Archived"]);
const authorItems = ref(["All", "Anthony Fu", "You"]);

defineShortcuts({
  o: () => (open.value = !open.value),
});

const posts = ref([
  {
    id: 1,
    title: "Introducing Nuxt Icon v1",
    description:
      "Discover Nuxt Icon v1 - a modern, versatile, and customizable icon solution for your Nuxt projects.",
    image: "https://nuxt.com/assets/blog/nuxt-icon/cover.png",
    date: "2024-11-25",
    status: "Published",
    author: "Anthony Fu",
    authors: [
      {
        name: "Anthony Fu",
        description: "antfu7",
        avatar: { src: "https://github.com/antfu.png" },
        to: "https://github.com/antfu",
        target: "_blank",
      },
    ],
  },
  {
    id: 2,
    title: "Introducing Nuxt Icon v1",
    description:
      "Discover Nuxt Icon v1 - a modern, versatile, and customizable icon solution for your Nuxt projects.",
    image: "https://nuxt.com/assets/blog/nuxt-icon/cover.png",
    date: "2024-11-25",
    status: "Published",
    author: "Anthony Fu",
    authors: [
      {
        name: "Anthony Fu",
        description: "antfu7",
        avatar: { src: "https://github.com/antfu.png" },
        to: "https://github.com/antfu",
        target: "_blank",
      },
    ],
  },
  {
    id: 3,
    title: "Introducing Nuxt Icon v1",
    description:
      "Discover Nuxt Icon v1 - a modern, versatile, and customizable icon solution for your Nuxt projects.",
    image: "https://nuxt.com/assets/blog/nuxt-icon/cover.png",
    date: "2024-11-25",
    status: "Published",
    author: "Anthony Fu",
    authors: [
      {
        name: "Anthony Fu",
        description: "antfu7",
        avatar: { src: "https://github.com/antfu.png" },
        to: "https://github.com/antfu",
        target: "_blank",
      },
    ],
  },
  {
    id: 3,
    title: "Introducing Nuxt Icon v1",
    description:
      "Discover Nuxt Icon v1 - a modern, versatile, and customizable icon solution for your Nuxt projects.",
    image: "https://nuxt.com/assets/blog/nuxt-icon/cover.png",
    date: "2024-11-25",
    status: "Published",
    author: "Anthony Fu",
    authors: [
      {
        name: "Anthony Fu",
        description: "antfu7",
        avatar: { src: "https://github.com/antfu.png" },
        to: "https://github.com/antfu",
        target: "_blank",
      },
    ],
  },
]);

const page = ref(5);

const filteredPosts = computed(() => {
  return posts.value.filter((post) => {
    const statusMatch =
      statusFilter.value === "All" || post.status === statusFilter.value;
    const authorMatch =
      authorFilter.value === "All" || post.author === authorFilter.value;
    return statusMatch && authorMatch;
  });
});

const deletePost = async (id: number) => {
  if (confirm("Are you sure you want to delete this post?")) {
    posts.value = posts.value.filter((post) => post.id !== id);
  }
};
</script>
