<script setup lang="ts">
import type { FooterColumn } from "@nuxt/ui";

const columns: FooterColumn[] = [
  {
    label: "Jesus saves You",
    children: [
      {
        label: "idk bro",
      },
    ],
  },
  {
    label: "Jesus saves You",
    children: [
      {
        label: "idk bro",
      },
    ],
  },
  {
    label: "Community",
    children: [
      {
        label: "Nuxters",
        to: "https://nuxters.nuxt.com",
        target: "_blank",
      },
      {
        label: "Video Courses",
        to: "https://masteringnuxt.com/nuxt3?ref=nuxt",
        target: "_blank",
      },
      {
        label: "Nuxt on GitHub",
        to: "https://github.com/nuxt",
        target: "_blank",
      },
    ],
  },
  {
    label: "Solutions",
    children: [
      {
        label: "Nuxt Content",
        to: "https://content.nuxt.com/",
        target: "_blank",
      },
      {
        label: "Nuxt DevTools",
        to: "https://devtools.nuxt.com/",
        target: "_blank",
      },
      {
        label: "Nuxt Image",
        to: "https://image.nuxt.com/",
        target: "_blank",
      },
      {
        label: "Nuxt UI",
        to: "https://ui.nuxt.com/",
        target: "_blank",
      },
    ],
  },
];
</script>
<template>
  <UFooter>
    <template #top>
      <UContainer>
        <UFooterColumns :columns="columns" />
      </UContainer>
    </template>
    <p class="text-muted text-[10px]">
      Copyright © {{ new Date().getFullYear() }}
    </p>
  </UFooter>
</template>
