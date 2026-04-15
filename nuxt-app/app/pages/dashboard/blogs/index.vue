<template>
  <div class="m-5">
    <!-- Header -->
    <div
      class="sticky top-0 z-50 mb-12 -mx-5 px-5 light:bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-gray-800"
    >
      <div class="space-y-5">
        <h1 class="text-4xl font-bold mb-2">Blogs Management</h1>
      </div>
      <div
        class="flex flex-col sm:flex-row sm:items-center mb-5 sm:justify-between gap-4 sm:gap-5"
      >
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-5">
          <UInput
            v-model="search"
            icon="i-heroicons-magnifying-glass"
            placeholder="Search blogs..."
            class="w-full sm:w-64"
          />
          <USelectMenu
            v-model="statusFilter"
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
          <UButton :to="DASHBOARD_ROUTES.BLOGS_CREATE" class="w-full sm:w-auto">
            <UIcon name="i-heroicons-plus" />
            New
          </UButton>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="blogs.length === 0 && !blogStore.loading" class="text-center py-12">
      <p class="text-gray-500 mb-4">No blog posts found</p>
      <UButton :to="DASHBOARD_ROUTES.BLOGS_CREATE">Create your first blog post</UButton>
    </div>

    <!-- Blog Posts Grid -->
    <div
      v-else
      class="grid gap-4"
      style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))"
    >
      <div v-for="blog in blogs" :key="blog.id" class="relative group">
        <UBlogPost
          :title="blog.title"
          :description="blog.excerpt"
          :image="blog.thumbnail"
          :date="blog.published_at"
          :badge="blog.status"
          :authors="[
            {
              name: blog.author.name,
              description: blog.author.role,
              avatar: { src: blog.author.avatar },
            },
          ]"
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
            :to="`/dashboard/blogs/${blog.id}/edit`"
          />
          <UButton
            icon="i-heroicons-trash"
            color="primary"
            variant="ghost"
            size="sm"
            @click="openDeleteModal(blog.id)"
          />
        </div>
      </div>
    </div>

    <div class="flex justify-center mt-8">
      <UPagination
        v-model:page="page"
        :total="blogStore.meta.total"
        :items-per-page="blogStore.meta.per_page"
      />
    </div>

    <ConfirmModal
      v-model="showConfirmModal"
      message="Are you sure you want to delete this blog post?"
      @confirm="deleteBlog"
    />
  </div>
</template>

<script setup lang="ts">
import ConfirmModal from "~/components/dashboard/ConfirmModal.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import type { BlogIndexParams } from "~/services/blogs";

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});

const blogStore = useBlogStore();
const { blogs } = storeToRefs(blogStore);
const authStore = useAuthStore();

const page = ref(1);
const search = ref("");
const statusFilter = ref("All");
const authorFilter = ref("All");

const statusItems = ["All", "Draft", "Published", "Archived"];
const authorItems = ["All", "Mine"];

const fetchBlogs = () => {
  const params: BlogIndexParams = { page: page.value };
  if (search.value) params["filter[title]"] = search.value;
  if (statusFilter.value !== "All") params["filter[status]"] = statusFilter.value.toLowerCase();
  if (authorFilter.value === "Mine" && authStore.user) params["filter[author_id]"] = authStore.user.id;
  blogStore.getBlogs(params);
};

onMounted(fetchBlogs);

watch(page, fetchBlogs);
watch(statusFilter, () => { page.value = 1; fetchBlogs(); });
watch(authorFilter, () => { page.value = 1; fetchBlogs(); });

let searchTimer: ReturnType<typeof setTimeout>;
watch(search, () => {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => { page.value = 1; fetchBlogs(); }, 400);
});

const selectId = ref<number | null>(null);
const showConfirmModal = ref(false);

const openDeleteModal = (id: number) => {
  selectId.value = id;
  showConfirmModal.value = true;
};

const deleteBlog = async () => {
  if (!selectId.value) return;
  await blogStore.deleteBlog(selectId.value);
  showConfirmModal.value = false;
  await fetchBlogs();
};
</script>
