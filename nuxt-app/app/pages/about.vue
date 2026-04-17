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
    <UPageHero
      title="About Us"
      class="bg-cover bg-center bg-fixed min-h-[50%]"
      :style="{ backgroundImage: `linear-gradient(rgba(255,255,255,0.2), rgba(0,0,0,0.5)), url(${churchBuilding})` }"
    />

    <UPageSection
      title="Our Mission"
      headline="Who We Are"
      :description="settings.about_mission_text || 'We exist to glorify God by making disciples of Jesus Christ.'"
    />

    <section class="bg-gradient-to-r from-slate-900 to-slate-800 py-12 sm:py-16">
      <UContainer>
        <div class="grid grid-cols-3 gap-4 sm:gap-8">
          <div v-for="stat in stats" :key="stat.label" class="text-center">
            <p class="text-3xl sm:text-4xl font-bold text-amber-400">{{ stat.number }}</p>
            <p class="text-white/70 text-sm sm:text-base mt-2">{{ stat.label }}</p>
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
