// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  css: ["./app/assets/css/main.css"],
  devtools: { enabled: true },
  modules: ["@nuxt/eslint", "@nuxt/ui", "@nuxt/icon", "@nuxtjs/color-mode"],
  colorMode: {
    preference: "light", // Sets the default theme to light mode
  },
});

