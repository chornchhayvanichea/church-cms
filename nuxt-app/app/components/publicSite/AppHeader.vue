<script setup lang="ts">
import type { NavigationMenuItem } from "@nuxt/ui";

const route = useRoute();

const openSearchModal = ref(false);
const items = computed<NavigationMenuItem[]>(() => [
  {
    label: "Home",
    to: "/",
    active: route.path == "/",
  },
  {
    label: "About",
    to: "/about",
    active: route.path.startsWith("/about"),
  },
  {
    label: "Sermons",
    to: "/sermons",
    active: route.path.startsWith("/sermons"),
  },
  {
    label: "Events",
    to: "/events",
    active: route.path.startsWith("/events"),
  },
  {
    label: "Blogs",
    to: "/blogs",
    active: route.path.startsWith("/blogs"),
  },
  {
    label: "Contact",
    to: "/contact",
    active: route.path.startsWith("/contacts"),
  },
]);
</script>

<template>
  <UHeader toggle-side="right">
    <template #title>
      <Logo class="h-6 w-auto" />
      Jesus Saves You
    </template>

    <UNavigationMenu :items="items" />

    <template #right>
      <UButton variant="ghost" color="neutral" @click="openSearchModal = true">
        <Icon name="lucide:search" />
      </UButton>

      <UColorModeButton />
      <UModal v-model:open="openSearchModal">
        <template #content>
          <UCommandPalette class="h-48 m-4" />
        </template>
      </UModal>
      <UButton label="Donate" variant="outline" color="primary" to="/donate" />
    </template>
    <template #body>
      <UNavigationMenu :items="items" orientation="vertical" class="-mx-2.5" />
    </template>
  </UHeader>
</template>
