<script setup lang="ts">
import ConfirmModal from "~/components/dashboard/ConfirmModal.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import { UserRole } from "~/types/userTypes";
import type { UserIndexParams } from "~/services/users";

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});

const userStore = useUserStore();
const { users } = storeToRefs(userStore);

const page = ref(1);
const search = ref("");
const roleFilter = ref("All");
const expandedIds = ref<Set<number>>(new Set());

const roleItems = ["All", "Admin", "Editor"];

const fetchUsers = () => {
  const params: UserIndexParams = { page: page.value };
  if (search.value) params["filter[name]"] = search.value;
  if (roleFilter.value !== "All")
    params["filter[role]"] = roleFilter.value.toLowerCase();
  userStore.getUsers(params);
};

onMounted(fetchUsers);
watch(page, fetchUsers);
watch(roleFilter, () => {
  page.value = 1;
  fetchUsers();
});

let searchTimer: ReturnType<typeof setTimeout>;
watch(search, () => {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    page.value = 1;
    fetchUsers();
  }, 400);
});

const toggle = (id: number) => {
  const next = new Set(expandedIds.value);
  next.has(id) ? next.delete(id) : next.add(id);
  expandedIds.value = next;
};

const selectedId = ref<number | null>(null);
const showConfirmModal = ref(false);

const openDeleteModal = (id: number) => {
  selectedId.value = id;
  showConfirmModal.value = true;
};

const deleteUser = async () => {
  if (!selectedId.value) return;
  await userStore.deleteUser(selectedId.value);
  await fetchUsers();
};
</script>

<template>
  <div class="px-6 py-8 space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm text-muted mb-1">Management</p>
        <h1 class="text-2xl font-semibold text-highlighted">Users</h1>
      </div>
      <UButton :to="DASHBOARD_ROUTES.USERS_CREATE" icon="i-lucide-plus" label="New User" />
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap gap-3">
      <UInput
        v-model="search"
        icon="i-heroicons-magnifying-glass"
        placeholder="Search by name..."
        class="w-64"
      />
      <USelectMenu
        v-model="roleFilter"
        :items="roleItems"
        placeholder="Filter by role"
        class="w-40"
      />
    </div>

    <!-- List -->
    <div class="divide-y divide-default border border-default rounded-md">
      <div v-if="users.length === 0 && !userStore.loading" class="py-12 text-center text-sm text-muted">
        No users found.
      </div>

      <div v-for="item in users" :key="item.id">
        <!-- Row -->
        <div
          class="flex items-center gap-4 px-4 py-3 hover:bg-elevated/50 cursor-pointer select-none"
          @click="toggle(item.id)"
        >
          <UIcon
            name="i-lucide-chevron-right"
            class="w-4 h-4 text-muted shrink-0 transition-transform duration-200"
            :class="{ 'rotate-90': expandedIds.has(item.id) }"
          />
          <UAvatar :src="item.avatar" :alt="item.name" size="sm" loading="lazy" class="shrink-0" />
          <div class="flex-1 min-w-0">
            <p class="font-medium text-highlighted truncate">{{ item.name }}</p>
            <p class="text-xs text-muted">{{ item.email }}</p>
          </div>
          <UBadge
            :color="item.role === UserRole.admin ? 'primary' : 'neutral'"
            variant="subtle"
            class="capitalize shrink-0"
          >
            {{ item.role }}
          </UBadge>
          <div class="flex gap-1 shrink-0" @click.stop>
            <UButton
              icon="i-lucide-edit"
              size="sm"
              color="neutral"
              variant="ghost"
              :to="DASHBOARD_ROUTES.USERS_EDIT(item.id)"
            />
            <UButton
              icon="i-lucide-trash"
              size="sm"
              color="error"
              variant="ghost"
              @click="openDeleteModal(item.id)"
            />
          </div>
        </div>

        <!-- Expanded details -->
        <div v-if="expandedIds.has(item.id)" class="border-t border-default bg-elevated/30 px-10 py-4">
          <dl class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm">
            <div>
              <dt class="text-muted text-xs uppercase tracking-wider mb-0.5">Email</dt>
              <dd class="text-highlighted">{{ item.email }}</dd>
            </div>
            <div>
              <dt class="text-muted text-xs uppercase tracking-wider mb-0.5">Role</dt>
              <dd class="capitalize text-highlighted">{{ item.role }}</dd>
            </div>
            <div>
              <dt class="text-muted text-xs uppercase tracking-wider mb-0.5">Joined</dt>
              <dd class="text-highlighted">{{ new Date(item.created_at).toLocaleDateString() }}</dd>
            </div>
            <div>
              <dt class="text-muted text-xs uppercase tracking-wider mb-0.5">Last Updated</dt>
              <dd class="text-highlighted">{{ new Date(item.updated_at).toLocaleDateString() }}</dd>
            </div>
          </dl>
        </div>
      </div>
    </div>

    <UPagination
      v-model:page="page"
      :total="userStore.meta.total"
      :items-per-page="userStore.meta.per_page"
      class="flex justify-center mt-4"
    />

    <ConfirmModal
      v-model="showConfirmModal"
      message="Are you sure you want to delete this user?"
      @confirm="deleteUser"
    />
  </div>
</template>
