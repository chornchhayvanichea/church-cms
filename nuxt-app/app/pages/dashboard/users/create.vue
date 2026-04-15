<template>
  <div class="max-w-xl mx-auto px-6 py-8">
    <div class="mb-8">
      <p class="text-sm text-muted mb-1">Users</p>
      <h1 class="text-2xl font-semibold text-highlighted">Create User</h1>
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
          <UFormField label="Password" required>
            <UInput v-model="formData.password" type="password" placeholder="Min. 8 characters" class="w-full" />
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
        <UButton :loading="userStore.loading" @click="submitHandler">Create User</UButton>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import MediaPicker from "~/components/dashboard/MediaPicker.vue";
import { DASHBOARD_ROUTES } from "~/constants/routes";
import { UserRole, type UserStoreData } from "~/types/userTypes";

definePageMeta({ layout: "dashboard", middleware: "dashboard" });

const userStore = useUserStore();

const roleOptions = [
  { label: "Editor", value: UserRole.editor },
  { label: "Admin", value: UserRole.admin },
];

const formData = ref<UserStoreData>({
  name: "",
  email: "",
  password: "",
  role: UserRole.editor,
});

const submitHandler = async () => {
  await userStore.createUser(formData.value);
  navigateTo(DASHBOARD_ROUTES.USERS);
};
</script>
