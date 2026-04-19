<script setup lang="ts">
import type { PageFeatureProps, ButtonProps } from "@nuxt/ui";
import churchBuilding from "../assets/images/crosswheat.jpg";

useHead({ title: "About Us" });

const { settings } = await usePublicSettings();

const stats = computed(() => [
  { number: settings.value.home_stat_1_number || "500+", label: settings.value.home_stat_1_label || "Active Members" },
  { number: settings.value.home_stat_2_number || "25+", label: settings.value.home_stat_2_label || "Years Serving" },
  { number: settings.value.home_stat_3_number || "100%", label: settings.value.home_stat_3_label || "Faith Based" },
]);

const values = computed<PageFeatureProps[]>(() => [
  { title: settings.value.about_value_1_title || "Faith in Christ", description: settings.value.about_value_1_desc || "", icon: "i-lucide-cross" },
  { title: settings.value.about_value_2_title || "Love & Compassion", description: settings.value.about_value_2_desc || "", icon: "i-lucide-heart" },
  { title: settings.value.about_value_3_title || "Community", description: settings.value.about_value_3_desc || "", icon: "i-lucide-users-round" },
  { title: settings.value.about_value_4_title || "Service", description: settings.value.about_value_4_desc || "", icon: "i-lucide-hand-heart" },
]);

const ctaLinks: ButtonProps[] = [{ label: "Visit Us", to: "/contact" }];
</script>

<template>
  <div class="overflow-hidden">
    <div
      class="relative min-h-[44vh] flex items-end bg-[#0c0c0c] bg-cover bg-center overflow-hidden"
      :style="{ backgroundImage: `url(${churchBuilding})` }"
    >
      <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/30 to-black/80" />
      <div class="relative z-10 w-full max-w-5xl mx-auto px-5 sm:px-8 pt-28 pb-10 sm:pb-12">
        <div class="flex items-center gap-3 mb-4">
          <div class="h-px w-8 bg-[#c9a96e] opacity-60" />
          <p class="text-[#c9a96e] text-[0.65rem] font-medium tracking-[0.25em] uppercase opacity-80">Who We Are</p>
          <div class="h-px w-8 bg-[#c9a96e] opacity-60" />
        </div>
        <h1
          class="text-white leading-none"
          style="font-family: 'Cormorant Garamond', serif; font-size: clamp(3rem, 8vw, 5rem); font-weight: 500; letter-spacing: -0.02em;"
        >
          About Us
        </h1>
        <p class="text-white/55 text-base leading-relaxed mt-3 max-w-lg" style="font-weight: 300;">
          {{ settings.about_mission_text || 'A community rooted in faith, growing in love, reaching the world.' }}
        </p>
      </div>
    </div>

    <UPageSection
      title="Our Mission"
      headline="Who We Are"
      :description="settings.about_mission_text || 'We exist to glorify God by making disciples of Jesus Christ.'"
    />

    <section class="relative bg-[#0c0c0c] py-12 sm:py-16 overflow-hidden">
      <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 28px 28px;" />
      <UContainer class="relative">
        <div class="grid grid-cols-3 divide-x divide-white/10">
          <div v-for="stat in stats" :key="stat.label" class="text-center px-4 sm:px-8">
            <p class="text-[#c9a96e] mb-1.5" style="font-family: 'Cormorant Garamond', serif; font-size: clamp(2rem, 5vw, 3rem); font-weight: 500;">
              {{ stat.number }}
            </p>
            <p class="text-white/45 text-xs sm:text-sm" style="font-weight: 300;">{{ stat.label }}</p>
          </div>
        </div>
      </UContainer>
    </section>

    <UPageSection
      title="Our Core Values"
      headline="What We Believe"
      :features="values"
      :ui="{ features: 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8' }"
      class="bg-gray-100"
    />

    <UPageSection title="Meet Our Pastor" headline="Spiritual Leadership" description="Our pastoral team is dedicated to shepherding our congregation with wisdom, compassion, and biblical truth.">
      <div class="flex flex-col lg:flex-row gap-8 items-center lg:items-start">
        <div class="flex-shrink-0 w-64 h-64 rounded-lg overflow-hidden shadow-lg bg-gray-100">
          <img
            :src="settings.about_pastor_image || 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&h=400&fit=crop'"
            alt="Pastor"
            class="w-full h-full object-cover"
          />
        </div>
        <div class="flex-1">
          <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            {{ settings.about_pastor_name || "Pastor John Smith" }}
          </h3>
          <p class="text-lg text-amber-600 font-semibold mb-4">
            {{ settings.about_pastor_title || "Senior Pastor" }}
          </p>
          <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
            {{ settings.about_pastor_bio || "Our pastor leads the congregation with passion and dedication." }}
          </p>
        </div>
      </div>
    </UPageSection>

    <UPageCTA
      title="Ready to Join Our Community?"
      :description="settings.home_cta_description || 'We\'d love to meet you this Sunday!'"
      :links="ctaLinks"
      class="bg-gray-100"
    />
  </div>
</template>
