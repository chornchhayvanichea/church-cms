<script setup lang="ts">
import { ref } from "vue";
import type { ButtonProps, BlogPostProps, PageFeatureProps } from "@nuxt/ui";
import crosswheat from "../assets/images/crosswheat.jpg";
import sermon from "../assets/images/sermon.png";

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
    <section class="py-16 sm:py-20 bg-gradient-to-r from-slate-50 to-gray-100">
      <UContainer>
        <div class="text-center mb-12 sm:mb-16">
          <p class="text-amber-600 font-semibold uppercase tracking-wider mb-2">
            Our Mission
          </p>
          <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
            Ministries & Groups
          </h2>
          <div
            class="w-16 h-1 bg-gradient-to-r from-amber-400 to-amber-600 mx-auto"
          ></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <UPageCard
            v-for="(ministry, idx) in ministries"
            :key="ministry.title"
            :title="ministry.title"
            :description="ministry.description"
            :icon="ministry.icon"
            :class="{ 'md:col-span-2': idx === 0 }"
          />
        </div>
      </UContainer>
    </section>
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
      description="Lectus, et tristique, dui ipsum tincidunt vitae laoreet elementum eu at volutpat. Et a mi, etiam montes dapibus diam lectus metus, vel nibh nibh. Suspendisse, vitae, efficitur lectus fermentum lacus vestibulum vulputate varius sit pulvinar."
    >
      <div class="space-y-6">
        <UPageCard
          title="Tailwind CSS"
          description="Nuxt UI integrates with latest Tailwind CSS, bringing significant improvements."
          icon="i-simple-icons-tailwindcss"
          orientation="horizontal"
          class="border-t-none"
          variant="naked"
          reverse
          to="/"
          target="_blank"
        >
          <img
            src="../assets/css/jesus.png"
            alt="Tailwind CSS"
            class="w-full"
          />
        </UPageCard>
        <USeparator />
        <UPageCard
          title="Tailwind CSS"
          description="Nuxt UI integrates with latest Tailwind CSS, bringing significant improvements."
          icon="i-simple-icons-tailwindcss"
          orientation="horizontal"
          variant="naked"
          to="/"
          target="_blank"
        >
          <img
            src="../assets/css/jesus.png"
            alt="Tailwind CSS"
            class="w-full"
          />
        </UPageCard>
        <USeparator />
        <UPageCard
          title="Tailwind CSS"
          description="Nuxt UI integrates with latest Tailwind CSS, bringing significant improvements."
          icon="i-simple-icons-tailwindcss"
          orientation="horizontal"
          reverse
          variant="naked"
          to="/"
          target="_blank"
        >
          <img
            src="../assets/css/jesus.png"
            alt="Tailwind CSS"
            class="w-full"
          />
        </UPageCard>
      </div>
    </UPageSection>
    <!-- LATEST SERMON SECTION -->
    <section
      class="relative py-16 sm:py-20 overflow-hidden"
      :style="{ backgroundImage: `url(${sermon})` }"
    >
      <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

      <UContainer>
        <div class="relative z-10 max-w-3xl">
          <p class="text-amber-300 font-semibold uppercase tracking-wider mb-2">
            Latest Message
          </p>
          <h2 class="text-4xl sm:text-5xl font-bold text-white mb-4">
            This Week's Sermon
          </h2>
          <p class="text-lg text-white/80 mb-8 leading-relaxed">
            Discover how God's Word transforms lives and brings hope in every
            circumstance. Join us as we dive deep into Scripture and uncover
            timeless truths that matter today.
          </p>
          <UButton
            to="/sermons"
            icon="i-lucide-play"
            size="lg"
            color="success"
            trailing
          >
            Watch Full Sermon
          </UButton>
        </div>
      </UContainer>
    </section>

    <!-- SERMON CAROUSEL -->
    <section class="py-16 sm:py-20 bg-white">
      <UContainer>
        <div class="text-center mb-12 sm:mb-16">
          <p class="text-amber-600 font-semibold uppercase tracking-wider mb-2">
            Spiritual Growth
          </p>
          <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
            Recent Blogs
          </h2>
          <div
            class="w-16 h-1 bg-gradient-to-r from-amber-400 to-amber-600 mx-auto"
          ></div>
        </div>

        <UBlogPosts :posts="sermons" />

        <div class="text-center mt-12">
          <UButton
            to="/sermons"
            variant="outline"
            color="success"
            trailing-icon="i-lucide-arrow-right"
          >
            View All Sermons
          </UButton>
        </div>
      </UContainer>
    </section>

    <!-- CTA FINAL SECTION -->
    <UPageCTA
      title="Ready to Join Our Community?"
      description="We'd love to see you this Sunday! Experience authentic worship, spiritual growth, and meaningful fellowship."
      :links="ctaLinks"
    />
  </div>
</template>
