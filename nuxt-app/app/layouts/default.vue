<script setup lang="ts">
import AppFooter from "~/components/publicSite/AppFooter.vue";
import AppHeader from "~/components/publicSite/AppHeader.vue";

useHead({
  link: [
    { rel: "preconnect", href: "https://fonts.googleapis.com" },
    {
      rel: "stylesheet",
      href: "https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap",
    },
  ],
});
</script>

<template>
  <div style="font-family: &quot;DM Sans&quot;, sans-serif">
    <AppHeader />
    <UMain>
      <slot />
    </UMain>
    <AppFooter />
  </div>
</template>
