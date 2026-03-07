<template>
  <div>
    <!-- Blog Posts Grid -->
    <div
      class="grid gap-3"
      style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))"
    >
      <div v-for="post in filteredPosts" :key="post.id" class="relative group">
        <UCard
          :ui="{
            root: 'rounded-none',
            body: 'p-0 sm:p-0',
          }"
          variant="soft"
        >
          <img :src="post.image" class="w-full h-48 object-cover" />
        </UCard>
        <!-- Action buttons on hover -->
        <div
          class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex gap-2"
        >
          <UButton
            icon="i-heroicons-eye"
            color="primary"
            variant="ghost"
            size="sm"
            @click="openPreview(post.image)"
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
    <UModal v-model:open="isOpen" fullscreen>
      <template #content>
        <div
          class="relative w-full h-full flex items-center justify-center bg-black"
        >
          <UButton
            icon="i-heroicons-x-mark"
            color="primary"
            variant="ghost"
            class="absolute top-4 right-4 z-10"
            @click="isOpen = false"
          />
          <img
            :src="selectedImage!"
            class="max-w-full max-h-full object-contain cursor-zoom-in"
            :style="{
              transform: `scale(${zoom})`,
              transition: 'transform 0.2s',
            }"
            @wheel.prevent="handleZoom"
          />
        </div>
      </template>
    </UModal>
  </div>
</template>

<script setup lang="ts">
const statusFilter = ref("All");
const authorFilter = ref("All");

const selectedImage = ref<string | null>(null);
const isOpen = ref(false);

const zoom = ref(1);
const handleZoom = (e: WheelEvent) => {
  zoom.value = Math.min(Math.max(zoom.value - e.deltaY * 0.001, 0.5), 5);
};

const openPreview = (url: string) => {
  selectedImage.value = url;
  zoom.value = 1;
  isOpen.value = true;
};

const deletePost = async (id: number) => {
  if (confirm("Are you sure you want to delete this post?")) {
    posts.value = posts.value.filter((post) => post.id !== id);
  }
};
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

const filteredPosts = computed(() => {
  return posts.value.filter((post) => {
    const statusMatch =
      statusFilter.value === "All" || post.status === statusFilter.value;
    const authorMatch =
      authorFilter.value === "All" || post.author === authorFilter.value;
    return statusMatch && authorMatch;
  });
});
</script>

<style scoped></style>
