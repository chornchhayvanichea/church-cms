<script setup lang="ts">
import ConfirmModal from "~/components/dashboard/ConfirmModal.vue";
import type { DropdownMenuItem, TableColumn } from "@nuxt/ui";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import type { Blog } from "~/types/blogTypes";
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

const truncate = (str: string | undefined, len = 32) => {
  if (!str) return "";
  return str.length > len ? str.slice(0, len) + "…" : str;
};

const UBadge = resolveComponent("UBadge");

const columns: TableColumn<Blog>[] = [
  { id: "action", header: "Action" },
  { accessorKey: "thumbnail", header: "Image" },
  { accessorKey: "title", header: "Title" },
  {
    accessorKey: "status",
    header: "Status",
    cell: ({ row }) => {
      const color = {
        draft: "neutral" as const,
        published: "success" as const,
        archived: "secondary" as const,
      }[row.getValue("status") as string];
      return h(UBadge, { class: "capitalize", variant: "subtle", color }, () => row.getValue("status"));
    },
  },
  { accessorKey: "author", header: "Author" },
  { accessorKey: "published_at", header: "Published" },
];

const toast = useToast();
const selectedId = ref<number | null>(null);
const showConfirmModal = ref(false);

const openDeleteModal = (id: number) => {
  selectedId.value = id;
  showConfirmModal.value = true;
};

const deleteBlog = async () => {
  if (!selectedId.value) return;
  try {
    await blogStore.deleteBlog(selectedId.value);
    toast.add({ title: "Blog post deleted.", color: "success", icon: "i-lucide-check-circle" });
    showConfirmModal.value = false;
    await fetchBlogs();
  } catch (e) {
    toast.add({ title: "Failed to delete post.", description: getApiErrorMessage(e), color: "error", icon: "i-lucide-x-circle" });
    showConfirmModal.value = false;
  }
};

function getDropdownActions(id: number): DropdownMenuItem[][] {
  return [
    [
      { label: "Edit", icon: "i-lucide-edit", to: `/dashboard/blogs/${id}/edit` },
      { label: "Delete", icon: "i-lucide-trash", color: "error", onSelect: () => openDeleteModal(id) },
    ],
  ];
}
</script>

<template>
  <div class="px-6 py-8 space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm text-muted mb-1">Content</p>
        <h1 class="text-2xl font-semibold text-highlighted">Blogs</h1>
      </div>
      <UButton :to="DASHBOARD_ROUTES.BLOGS_CREATE" icon="i-lucide-plus" label="New Post" />
    </div>

    <div class="flex flex-wrap gap-3">
      <UInput
        v-model="search"
        icon="i-heroicons-magnifying-glass"
        placeholder="Search title..."
        class="w-64"
      />
      <USelectMenu v-model="statusFilter" :items="statusItems" placeholder="Status" class="w-40" />
      <USelectMenu v-model="authorFilter" :items="authorItems" placeholder="Author" class="w-40" />
    </div>

    <div v-if="blogs.length === 0 && !blogStore.loading" class="py-16 text-center text-muted">
      <UIcon name="i-lucide-book-open" class="w-10 h-10 mx-auto mb-3 opacity-30" />
      <p class="text-sm">No blog posts found.</p>
      <UButton :to="DASHBOARD_ROUTES.BLOGS_CREATE" variant="soft" size="sm" class="mt-3">Create your first post</UButton>
    </div>

    <UCard v-else>
      <UTable :data="blogs" :columns="columns">
        <template #action-cell="{ row }">
          <UDropdownMenu :items="getDropdownActions(row.original.id)">
            <UButton icon="i-heroicons-ellipsis-vertical-solid" color="neutral" variant="ghost" aria-label="Actions" />
          </UDropdownMenu>
        </template>

        <template #thumbnail-cell="{ row }">
          <img
            v-if="row.original.thumbnail"
            :src="row.original.thumbnail"
            :alt="row.original.title"
            class="w-16 h-10 object-cover rounded"
            loading="lazy"
          />
          <div v-else class="w-16 h-10 rounded bg-(--color-background-secondary) flex items-center justify-center">
            <UIcon name="i-lucide-image" class="text-muted w-4 h-4" />
          </div>
        </template>

        <template #title-cell="{ row }">
          <div>
            <p class="font-medium text-highlighted max-w-56 truncate">{{ row.original.title }}</p>
            <p v-if="row.original.excerpt" class="text-xs text-muted mt-0.5 max-w-56 truncate">{{ row.original.excerpt }}</p>
          </div>
        </template>

        <template #author-cell="{ row }">
          <div class="flex items-center gap-2.5">
            <UAvatar :src="row.original.author.avatar" :alt="row.original.author.name" size="sm" loading="lazy" />
            <div>
              <p class="text-sm font-medium text-highlighted leading-tight">{{ row.original.author.name }}</p>
              <p class="text-xs text-muted leading-tight capitalize">{{ row.original.author.role }}</p>
            </div>
          </div>
        </template>

        <template #published_at-cell="{ row }">
          <span class="text-sm text-muted">
            {{ row.original.published_at ? new Date(row.original.published_at).toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" }) : "—" }}
          </span>
        </template>
      </UTable>
    </UCard>

    <UPagination
      v-model:page="page"
      :total="blogStore.meta.total"
      :items-per-page="blogStore.meta.per_page"
      class="flex justify-center mt-4"
    />

    <ConfirmModal
      v-model="showConfirmModal"
      message="Are you sure you want to delete this blog post?"
      @confirm="deleteBlog"
    />
  </div>
</template>
