// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  css: ["./app/assets/css/main.css"],
  devtools: { enabled: true },
  modules: [
    "@nuxt/eslint",
    "@nuxt/ui",
    "@nuxt/icon",
    "@nuxtjs/color-mode",
    "@pinia/nuxt",
  ],
  colorMode: {
    preference: "light", // Sets the default theme to light mode
  },
  vite: {
    optimizeDeps: {
      include: [
        "@nuxt/ui > prosemirror-state",
        "@nuxt/ui > prosemirror-transform",
        "@nuxt/ui > prosemirror-model",
        "@nuxt/ui > prosemirror-view",
        "@nuxt/ui > prosemirror-gapcursor",
      ],
    },
  },
});
