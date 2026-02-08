<script setup lang="ts">
import AppFooter from "~/components/publicSite/AppFooter.vue";
import AppHeader from "~/components/publicSite/AppHeader.vue";
</script>

<template>
  <div>
    <app-header />
    <UMain>
      <slot />
    </UMain>
    <AppFooter />
  </div>
</template>
