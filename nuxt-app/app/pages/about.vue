<script setup lang="ts">
import { ref } from "vue";
import type { ButtonProps, PageFeatureProps } from "@nuxt/ui";
import churchBuilding from "../assets/images/crosswheat.jpg";

// Page metadata
useHead({
  title: "About Us",
  meta: [
    {
      name: "description",
      content:
        "Learn about our church mission, values, and pastoral leadership.",
    },
  ],
});

// Quick stats
const stats = [
  { number: "500+", label: "Active Members" },
  { number: "25+", label: "Years Serving" },
  { number: "100%", label: "Faith Based" },
];

// Core values
const values = ref<PageFeatureProps[]>([
  {
    title: "Faith in Christ",
    description:
      "We believe in the transformative power of faith in Jesus Christ as our Lord and Savior.",
    icon: "i-lucide-cross",
  },
  {
    title: "Love & Compassion",
    description:
      "We extend love and compassion to all people, reflecting God's unconditional love.",
    icon: "i-lucide-heart",
  },
  {
    title: "Community",
    description:
      "We foster a welcoming community where everyone belongs and can grow together.",
    icon: "i-lucide-users-round",
  },
  {
    title: "Service",
    description:
      "We serve our neighbors and community, living out the Gospel through action.",
    icon: "i-lucide-hand-heart",
  },
]);

// CTA buttons
const ctaLinks = ref<ButtonProps[]>([
  {
    label: "Visit Us",
    to: "/contact",
  },
]);
</script>

<template>
  <div class="overflow-hidden">
    <!-- HERO SECTION -->
    <!--      description="We are a faith community dedicated to knowing God, growing in Christ, and serving others with love and compassion." -->
    <UPageHero
      title="About Us"
      class="bg-cover bg-center bg-fixed min-h-[50%]"
      :style="{
        backgroundImage: `linear-gradient(rgba(255,255 , 255, 0.2), rgba(0, 0, 0, 0.5)), url(${churchBuilding})`,
      }"
    />

    <!-- OUR MISSION SECTION -->
    <UPageSection
      title="Our Mission"
      headline="Who We Are"
      description="We exist to glorify God by making disciples of Jesus Christ who worship faithfully, live intentionally, and serve sacrificially. Through worship, fellowship, and outreach, we strive to make a lasting impact in our community and beyond."
    />

    <!-- QUICK STATS SECTION -->
    <section
      class="bg-gradient-to-r from-slate-900 to-slate-800 py-12 sm:py-16"
    >
      <UContainer>
        <div class="grid grid-cols-3 gap-4 sm:gap-8">
          <div v-for="stat in stats" :key="stat.label" class="text-center">
            <p class="text-3xl sm:text-4xl font-bold text-amber-400">
              {{ stat.number }}
            </p>
            <p class="text-white/70 text-sm sm:text-base mt-2">
              {{ stat.label }}
            </p>
          </div>
        </div>
      </UContainer>
    </section>

    <!-- CORE VALUES SECTION -->
    <UPageSection
      title="Our Core Values"
      headline="What We Believe"
      :features="values"
      :ui="{
        features: 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8',
      }"
      class="bg-gray-100"
    />

    <!-- PASTOR SECTION -->
    <UPageSection
      title="Meet Our Pastor"
      headline="Spiritual Leadership"
      description="Our pastoral team is dedicated to shepherding our congregation with wisdom, compassion, and biblical truth."
    >
      <div class="flex flex-col lg:flex-row gap-8 items-center lg:items-start">
        <div
          class="flex-shrink-0 w-64 h-64 rounded-lg overflow-hidden shadow-lg"
        >
          <img
            src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&h=400&fit=crop"
            alt="Pastor"
            class="w-full h-full object-cover"
          />
        </div>
        <div class="flex-1">
          <h3 class="text-3xl font-bold text-gray-900 mb-2">
            Pastor John Smith
          </h3>
          <p class="text-lg text-amber-600 font-semibold mb-4">Senior Pastor</p>
          <p class="text-gray-600 leading-relaxed mb-4">
            Pastor John has been leading our congregation with passion and
            dedication for over 15 years. With a heart for discipleship and
            community outreach, he brings biblical teaching that is both
            relevant and transformative.
          </p>
          <p class="text-gray-600 leading-relaxed">
            He holds a Master of Divinity from Seminary University and is
            committed to equipping believers to live out their faith with
            purpose and conviction. Pastor John and his wife Sarah have been
            married for 20 years and have three children.
          </p>
        </div>
      </div>
    </UPageSection>

    <!-- CTA FINAL SECTION -->
    <UPageCTA
      title="Ready to Join Our Community?"
      description="We'd love to meet you! Experience authentic worship, spiritual growth, and meaningful fellowship with us."
      :links="ctaLinks"
      class="bg-gray-100"
    />
  </div>
</template>
