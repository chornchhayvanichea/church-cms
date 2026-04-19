<script setup lang="ts">
import MediaPicker from "~/components/dashboard/MediaPicker.vue";
import { profileUpdateApi } from "~/services/users";
import type { UserUpdateData } from "~/types/userTypes";

definePageMeta({
  layout: "dashboard",
  middleware: "dashboard",
});

const authStore = useAuthStore();
const toast = useToast();

const form = reactive<UserUpdateData>({
  name: authStore.user?.name ?? "",
  email: authStore.user?.email ?? "",
  avatar: authStore.user?.avatar ?? undefined,
  password: "",
});

watch(() => authStore.user, (u) => {
  if (!u) return;
  form.name = u.name;
  form.email = u.email;
  form.avatar = u.avatar;
}, { immediate: true });

const saving = ref(false);

const submit = async () => {
  saving.value = true;
  try {
    const payload: UserUpdateData = {
      name: form.name,
      email: form.email,
      avatar: form.avatar,
    };
    if (form.password) payload.password = form.password;
    await profileUpdateApi(payload);
    await authStore.getUser();
    toast.add({ title: "Profile updated.", color: "success", icon: "i-lucide-check-circle" });
    form.password = "";
  } catch (e) {
    toast.add({ title: "Failed to update profile.", description: getApiErrorMessage(e), color: "error", icon: "i-lucide-x-circle" });
  } finally {
    saving.value = false;
  }
};
</script>

<template>
  <div class="px-6 py-8">
    <div class="mb-8">
      <p class="text-sm text-muted mb-1">Settings</p>
      <h1 class="text-2xl font-semibold text-highlighted">My Profile</h1>
    </div>

    <div class="max-w-xl space-y-6">
      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">Avatar</p>
        </template>
        <div class="flex items-center gap-5">
          <UAvatar
            :src="typeof form.avatar === 'string' ? form.avatar : undefined"
            :alt="form.name"
            size="xl"
          />
          <div class="flex-1">
            <MediaPicker v-model="form.avatar" accept="image/*" mime-type="image" />
            <p class="text-xs text-muted mt-2">JPG, PNG or WebP. Recommended 200×200.</p>
          </div>
        </div>
      </UCard>

      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">Account Info</p>
        </template>
        <div class="space-y-4">
          <UFormField label="Name">
            <UInput v-model="form.name" placeholder="Your name" class="w-full" />
          </UFormField>
          <UFormField label="Email">
            <UInput v-model="form.email" type="email" placeholder="your@email.com" class="w-full" />
          </UFormField>
          <UFormField label="Role">
            <UInput :value="authStore.user?.role ?? ''" disabled class="w-full capitalize" />
          </UFormField>
        </div>
      </UCard>

      <UCard>
        <template #header>
          <p class="text-sm font-medium text-muted uppercase tracking-wider">Change Password</p>
        </template>
        <UFormField label="New Password" hint="Leave blank to keep current password">
          <UInput v-model="form.password" type="password" placeholder="Min. 8 characters" class="w-full" />
        </UFormField>
      </UCard>

      <div class="flex justify-end">
        <UButton :loading="saving" icon="i-lucide-save" @click="submit">
          Save Changes
        </UButton>
      </div>
    </div>
  </div>
</template>
