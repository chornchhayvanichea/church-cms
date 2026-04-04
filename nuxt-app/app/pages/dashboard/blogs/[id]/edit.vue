<template>
  <div>
    <UDashboardToolbar
      class="sticky top-0 z-10 dark:bg-slate-900 light:bg-white"
    >
      <UNavigationMenu :items="tabs" highlight class="flex-1" />
    </UDashboardToolbar>
    <UContainer class="rounded-2xl p-10">
      <BlogEditor v-show="activeTab === 'editor'" v-model="form.content" />
      <BlogGeneral v-show="activeTab === 'general'" v-model="form" />

      <div class="space-x-2 space-y-5">
        <UButton :loading="blogStore.loading" @click="handleSubmit">
          Save
        </UButton>

        <UButton
          label="Cancel"
          color="neutral"
          variant="subtle"
          @click="hasChanges ? (isCancelModal = true) : cancelHandling()"
        />
        <UModal v-model:open="isCancelModal">
          <template #content>
            Are you sure you want to cancel?
            <UButton @click="cancelHandling">Yes</UButton>
            <UButton @click="isCancelModal = false">No</UButton>
          </template>
        </UModal>
      </div>
    </UContainer>
  </div>
</template>

<script setup lang="ts">
import type { NavigationMenuItem } from "@nuxt/ui";
import BlogEditor from "~/components/dashboard/editors/BlogEditor.vue";
import BlogGeneral from "~/components/dashboard/editors/BlogGeneral.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import { BlogStatus, type BlogStoreData } from "~/types/blogTypes";

const activeTab = useState("blogTab", () => "general");
const form = ref<BlogStoreData>({
  title: "",
  excerpt: "",
  thumbnail: undefined,
  published_at: "",
  status: BlogStatus.draft,
  content: "",
});

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});

const route = useRoute();
const id = route.params.id;

const blogStore = useBlogStore();

//get existing data if editing
onMounted(async () => {
  await blogStore.getBlog(Number(id));
  //using blog from store since it's consistent
  const blog = blogStore.blog;
  if (!blog) return;
  form.value = {
    title: blog.title ?? "",
    excerpt: blog.excerpt ?? "",
    thumbnail: blog.thumbnail ?? undefined,
    published_at: blog.published_at ?? "",
    status: blog.status ?? BlogStatus.draft,
    content: blog.content ?? "",
  };
});

const handleSubmit = async () => {
  await blogStore.updateBlog(form.value, Number(id));
};
const hasChanges = ref(false);
watch(
  form,
  () => {
    hasChanges.value = true;
  },
  { deep: true },
);

const isCancelModal = ref(false);

const cancelHandling = () => {
  navigateTo(DASHBOARD_ROUTES.BLOGS);
  form.value = {
    title: "",
    excerpt: "",
    thumbnail: undefined,
    published_at: "",
    content: "",
  };
};

const tabs = computed<NavigationMenuItem[][]>(() => [
  [
    {
      label: "General",
      icon: "i-lucide-users",
      active: activeTab.value === "general",
      onSelect: () => (activeTab.value = "general"),
    },
    {
      label: "Editor",
      icon: "i-lucide-user",
      active: activeTab.value === "editor",
      onSelect: () => (activeTab.value = "editor"),
    },
  ],
  [
    {
      label: "Help & Feedback",
      icon: "i-lucide-help-circle",
      to: "https://github.com/nuxt/ui/issues",
      target: "_blank",
    },
  ],
]);
</script>

<style scoped></style>
