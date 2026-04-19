<script setup lang="ts">
import type { NavigationMenuItem } from "@nuxt/ui";
import BlogEditor from "~/components/dashboard/editors/BlogEditor.vue";
import BlogGeneral from "~/components/dashboard/editors/BlogGeneral.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import { BlogStatus, type BlogStoreData } from "~/types/blogTypes";

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});

const activeTab = useState("blogTab", () => "general");
const form = ref<BlogStoreData>({
  title: "",
  excerpt: "",
  thumbnail: undefined,
  published_at: "",
  status: BlogStatus.draft,
  content: "",
});

const blogStore = useBlogStore();
const toast = useToast();

const handleSubmit = async () => {
  try {
    await blogStore.createBlog(form.value);
    toast.add({ title: "Blog post created.", color: "success", icon: "i-lucide-check-circle" });
    navigateTo(DASHBOARD_ROUTES.BLOGS);
  } catch (e) {
    toast.add({ title: "Failed to create post.", description: getApiErrorMessage(e), color: "error", icon: "i-lucide-x-circle" });
  }
};

const hasChanges = ref(false);
watch(form, () => { hasChanges.value = true; }, { deep: true });

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
      icon: "i-lucide-sliders-horizontal",
      active: activeTab.value === "general",
      onSelect: () => (activeTab.value = "general"),
    },
    {
      label: "Editor",
      icon: "i-lucide-pen-line",
      active: activeTab.value === "editor",
      onSelect: () => (activeTab.value = "editor"),
    },
  ],
]);
</script>

<template>
  <div>
    <div class="px-6 pt-6 pb-4 border-b border-default flex items-center justify-between">
      <div>
        <p class="text-sm text-muted mb-1">Blogs</p>
        <h1 class="text-2xl font-semibold text-highlighted">Create Post</h1>
      </div>
      <div class="flex gap-2">
        <UButton
          label="Cancel"
          color="neutral"
          variant="ghost"
          @click="hasChanges ? (isCancelModal = true) : cancelHandling()"
        />
        <UButton :loading="blogStore.loading" icon="i-lucide-save" @click="handleSubmit">
          Save
        </UButton>
      </div>
    </div>

    <UDashboardToolbar class="sticky top-0 z-10">
      <UNavigationMenu :items="tabs[0]!" highlight orientation="horizontal" />
    </UDashboardToolbar>

    <UContainer class="py-8">
      <BlogEditor v-show="activeTab === 'editor'" v-model="form.content" />
      <BlogGeneral v-show="activeTab === 'general'" v-model="form" />
    </UContainer>

    <UModal v-model:open="isCancelModal">
      <template #content>
        <div class="p-6 space-y-4">
          <p class="text-sm text-highlighted font-medium">Discard changes?</p>
          <p class="text-sm text-muted">Your unsaved changes will be lost.</p>
          <div class="flex justify-end gap-2">
            <UButton color="neutral" variant="ghost" @click="isCancelModal = false">Keep editing</UButton>
            <UButton color="error" variant="soft" @click="cancelHandling">Discard</UButton>
          </div>
        </div>
      </template>
    </UModal>
  </div>
</template>
