<script setup lang="ts">
import type { FormSubmitEvent } from "@nuxt/ui";
import z from "zod";
import { DASHBOARD_ROUTES } from "~/constants/routes";

const schema = z.object({
  email: z.email("Invalid email"),
  password: z.string().min(8, "Must be at least 8 characters"),
});
type Schema = z.output<typeof schema>;

const store = useAuthStore();

const state = reactive({ email: "", password: "" });

async function onSubmit(payload: FormSubmitEvent<Schema>) {
  await store.login(payload.data);
  if (store.user) {
    await navigateTo(DASHBOARD_ROUTES.ROOT);
  }
}
</script>

<template>
  <div class="w-full max-w-[380px]">
    <!-- Heading -->
    <div class="mb-8">
      <h2
        class="text-gray-900 dark:text-white font-medium mb-1.5"
        style="font-family: 'Cormorant Garamond', serif; font-size: 2.4rem; letter-spacing: -0.01em; line-height: 1.1;"
      >
        Welcome back
      </h2>
      <p class="text-gray-400 text-sm" style="font-family: 'DM Sans', sans-serif;">
        Sign in to access your dashboard
      </p>
    </div>

    <!-- Error -->
    <UAlert
      v-if="store.error"
      color="error"
      variant="soft"
      :description="store.error"
      class="mb-6"
    />

    <!-- Form -->
    <UForm :schema="schema" :state="state" class="space-y-5" @submit="onSubmit">
      <UFormField label="Email address" name="email">
        <UInput
          v-model="state.email"
          type="email"
          placeholder="you@gracechurch.org"
          size="lg"
          class="w-full"
          autocomplete="email"
        />
      </UFormField>

      <UFormField label="Password" name="password">
        <UInput
          v-model="state.password"
          type="password"
          placeholder="••••••••"
          size="lg"
          class="w-full"
          autocomplete="current-password"
        />
      </UFormField>

      <div class="pt-1">
        <UButton
          type="submit"
          size="lg"
          block
          color="neutral"
          :loading="store.loading"
          style="font-family: 'DM Sans', sans-serif; letter-spacing: 0.04em;"
        >
          Sign In
        </UButton>
      </div>
    </UForm>
  </div>
</template>
