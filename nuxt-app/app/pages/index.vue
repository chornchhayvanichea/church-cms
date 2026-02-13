<script setup lang="ts">
import { ref } from "vue";
import type { ButtonProps, BlogPostProps, PageFeatureProps } from "@nuxt/ui";
import crosswheat from "../assets/images/crosswheat.jpg";
import sermon from "../assets/images/sermon.png";

const eventItems = [
  {
    title: "Sunday Worship Service",
    description:
      "Join us every Sunday morning at 10 AM for an inspiring worship experience.",
    icon: "i-lucide-music",
    image: "https://picsum.photos/400/300?random=2",
    to: "/events/sunday-worship",
  },
  {
    title: "Midweek Prayer Meeting",
    description:
      "Wednesday evenings, we gather to intercede for our community.",
    icon: "i-lucide-heart-handshake",
    image: "https://picsum.photos/400/300?random=3",
    to: "/events/prayer-meeting",
  },
  {
    title: "Youth Group Gathering",
    description:
      "A dynamic space for young believers to grow in faith and build friendships.",
    icon: "i-lucide-users",
    image: "https://picsum.photos/400/300?random=4",
    to: "/events/youth-group",
  },
];
// Quick stats

const stats = [
  { number: "500+", label: "Active Members" },
  { number: "25+", label: "Years Serving" },
  { number: "100%", label: "Faith Based" },
];

// Ministries

const ministries = ref<PageFeatureProps[]>([
  {
    title: "Children's Ministry",
    description:
      "A safe, fun environment where kids learn about Jesus and grow in faith.",
    icon: "i-lucide-smile",
  },
  {
    title: "Youth Ministry",
    description:
      "Empowering young people to live out their faith with purpose and passion.",
    icon: "i-lucide-zap",
  },
  {
    title: "Community Outreach",
    description:
      "Serving our neighbors and making a real difference in our community.",
    icon: "i-lucide-heart",
  },
  {
    title: "Small Groups",
    description:
      "Connect deeply with others through meaningful Bible study and fellowship.",
    icon: "i-lucide-users-round",
  },
]);

// Sermons
const sermons = ref<BlogPostProps[]>([
  {
    title: "Faith in Uncertain Times",
    description:
      "Discover how to strengthen your faith when facing life's challenges.",
    image:
      "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=640&h=400&fit=crop",
    date: "Feb 9, 2026",
  },
  {
    title: "The Power of Prayer",
    description:
      "Learn about the transformative power of prayer in our daily lives.",
    image:
      "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=640&h=400&fit=crop",
    date: "Feb 2, 2026",
  },
  {
    title: "God's Love Never Fails",
    description: "Explore the depths of God's unconditional love and grace.",
    image:
      "https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=640&h=400&fit=crop",
    date: "Jan 26, 2026",
  },
]);
const links = ref<ButtonProps[]>([
  {
    label: "Listen",
    to: "/docs/getting-started",
    icon: "i-lucide-square-play",
  },
]);
// CTA buttons
const ctaLinks = ref<ButtonProps[]>([
  {
    label: "Get in Touch",
    to: "/contact",
  },
]);
</script>

<template>
  <div class="overflow-hidden">
    <!-- HERO SECTION -->
    <UPageHero
      title="Jesus Saves You"
      description="Penatibus pretium id, eros convallis tempor id nunc vel eu, finibus pharetra. Nullam libero nibh diam, tristique, arcu gravida quam diam lorem varius urna. Tempor."
      :links="links"
      :style="{ backgroundImage: `url(${crosswheat})` }"
      class="bg-cover bg-center"
      orientation="horizontal"
    />
    <!-- MINISTRIES SECTION -->
    <UPageSection
      title="Ministries"
      headline="Our Mission"
      :features="ministries"
      :ui="{
        features: 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8',
      }"
      class="bg-gray-100"
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

    <!-- UPCOMING EVENTS SECTION -->
    <UPageSection
      title="Upcoming Events"
      description="Join us for these exciting spiritual gatherings and community events."
      headline="What's Happening"
    >
      <div class="space-y-6">
        <template v-for="(event, idx) in eventItems" :key="event.title">
          <div class="flex gap-8 items-start">
            <div class="flex-1 p-6 sm:p-8">
              <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">
                {{ event.title }}
              </h3>
              <p
                class="text-base sm:text-lg text-gray-600 mb-4 leading-relaxed"
              >
                {{ event.description }}
              </p>
              <NuxtLink
                :to="event.to"
                class="inline-flex items-center gap-2 text-amber-600 font-semibold hover:text-amber-700 transition-colors"
              >
                Learn More
                <UIcon name="i-lucide-arrow-right" class="w-4 h-4" />
              </NuxtLink>
            </div>
            <div
              class="flex-shrink-0 w-full sm:w-96 h-64 sm:h-80 rounded-lg overflow-hidden shadow-lg"
            >
              <img
                :src="event.image"
                :alt="event.title"
                class="w-full h-full object-cover"
              />
            </div>
          </div>
          <USeparator v-if="idx < eventItems.length - 1" />
        </template>
      </div>
    </UPageSection>
    <!-- LATEST SERMON SECTION -->
    <UPageSection
      :style="{ backgroundImage: `url(${sermon})` }"
      title="Latest Sermon"
      orientation="horizontal"
      headline="This week sermon"
      description="Eu, pellentesque ligula dui sed, velit consequat ac bibendum eleifend praesent erat. Odio nibh maximus ligula faucibus, nunc tincidunt leo tortor facilisis vitae ut. Velit pellentesque tortor a, eleifend, nec."
      :links="links"
      :ui="{
        description: 'text-gray-300',
        title: 'text-gray-100',
      }"
    />
    <!-- SERMON CAROUSEL -->
    <UPageSection
      headline="spiritual Growth"
      title="Latest News"
      description="Lobortis nibh, imperdiet, vulputate dictumst ex tempor consequat aenean auctor metus et. Morbi penatibus, magna dui est volutpat eget convallis turpis dis congue vulputate. Ante, nulla luctus nullam eget, suspendisse."
      class="bg-gray-100"
    >
      <div>
        <UBlogPosts :posts="sermons" />
      </div>
    </UPageSection>
    <!-- CTA FINAL SECTION -->
    <UPageCTA
      title="Ready to Join Our Community?"
      description="We'd love to see you this Sunday! Experience authentic worship, spiritual growth, and meaningful fellowship."
      :links="ctaLinks"
    />
  </div>
</template>
