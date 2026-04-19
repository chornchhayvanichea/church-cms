<template>
  <div class="max-w-xl mx-auto px-6 py-8">
    <div class="mb-8">
      <p class="text-sm text-muted mb-1">Users</p>
      <h1 class="text-2xl font-semibold text-highlighted">Edit User</h1>
    </div>

    <div class="flex flex-col gap-6">
      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">Details</p>
        </template>
        <div class="flex flex-col gap-4">
          <UFormField label="Name" required>
            <UInput v-model="formData.name" placeholder="Full name" class="w-full" />
          </UFormField>
          <UFormField label="Email" required>
            <UInput v-model="formData.email" type="email" placeholder="email@example.com" class="w-full" />
          </UFormField>
          <UFormField label="New Password">
            <UInput
              v-model="formData.password"
              type="password"
              placeholder="Leave blank to keep current"
              class="w-full"
            />
          </UFormField>
          <UFormField label="Role" required>
            <USelect v-model="formData.role" :items="roleOptions" class="w-48" />
          </UFormField>
        </div>
      </UCard>

      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">Avatar</p>
        </template>
        <UFormField label="Avatar">
          <MediaPicker v-model="formData.avatar" accept="image/*" mime-type="image" />
        </UFormField>
      </UCard>

      <div class="flex justify-end gap-3">
        <UButton variant="ghost" color="neutral" @click="$router.back()">Cancel</UButton>
        <UButton :loading="userStore.loading" @click="submitHandler">Update User</UButton>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import MediaPicker from "~/components/dashboard/MediaPicker.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import { UserRole, type UserUpdateData } from "~/types/userTypes";

definePageMeta({ layout: "dashboard", middleware: "dashboard" });

const userStore = useUserStore();
const toast = useToast();
const route = useRoute();
const id = Number(route.params.id);

const roleOptions = [
  { label: "Editor", value: UserRole.editor },
  { label: "Admin", value: UserRole.admin },
];

const formData = ref<UserUpdateData>({
  name: "",
  email: "",
  password: "",
  role: UserRole.editor,
});

onMounted(async () => {
  await userStore.getUser(id);
  const u = userStore.user;
  if (!u) return;
  formData.value = {
    name: u.name ?? "",
    email: u.email ?? "",
    password: "",
    role: u.role ?? UserRole.editor,
    avatar: u.avatar ?? undefined,
  };
});

const submitHandler = async () => {
  try {
    await userStore.updateUser(formData.value, id);
    toast.add({ title: "User updated.", color: "success", icon: "i-lucide-check-circle" });
    navigateTo(DASHBOARD_ROUTES.USERS);
  } catch (e) {
    toast.add({ title: "Failed to update user.", description: getApiErrorMessage(e), color: "error", icon: "i-lucide-x-circle" });
  }
};
</script>
