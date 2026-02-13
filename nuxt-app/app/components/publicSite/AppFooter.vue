<script setup lang="ts">
import type { FooterColumn } from "@nuxt/ui";

const columns: FooterColumn[] = [
  {
    label: "Recent Posts",
    children: [
      {
        label: "idk bro",
      },
    ],
  },
  {
    label: "Contact Us",
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
    label: "Useful links",
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
  <UFooter class="bg-amber-950">
    <template #top>
      <UContainer>
        <UFooterColumns :columns="columns">
          <template #left>
            <h1 class="font-bold">Jesus saves you</h1>
            <p class="text-xs w-full">
              Semper vulputate quis, praesent, aenean lacus lorem sed ridiculus
              porta non massa. Imperdiet diam, non, nulla ultricies ac lectus
              arcu in fusce cras suspendisse. Aliquam.
            </p>
          </template>
        </UFooterColumns>
      </UContainer>
    </template>
    <p class="text-muted text-[10px]">
      Copyright © {{ new Date().getFullYear() }}
    </p>
  </UFooter>
</template>
