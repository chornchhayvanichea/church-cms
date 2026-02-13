<script setup lang="ts">
import type { PageFeatureProps, ButtonProps, BlogPostProps } from "@nuxt/ui";
import crosswheat from "../assets/images/crosswheat.jpg";
import sermon from "../assets/images/sermon.png";
const posts2 = ref<BlogPostProps[]>([
  {
    title: "Nuxt Icon v1",
    description: "Discover Nuxt Icon v1!",
    image: "https://nuxt.com/assets/blog/nuxt-icon/cover.png",
    date: "2024-11-25",
  },
  {
    title: "Nuxt 3.14",
    description: "Nuxt 3.14 is out!",
    image: "https://nuxt.com/assets/blog/v3.14.png",
    date: "2024-11-04",
  },
  {
    title: "Nuxt 3.13",
    description: "Nuxt 3.13 is out!",
    image: "https://nuxt.com/assets/blog/v3.13.png",
    date: "2024-08-22",
  },
]);
const features = ref<PageFeatureProps[]>([
  {
    title: "Icons",
    description:
      "Nuxt UI integrates with Nuxt Icon to access over 200,000+ icons from Iconify.",
    icon: "i-lucide-smile",
    to: "/docs/getting-started/integrations/icons",
  },
  {
    title: "Fonts",
    description:
      "Nuxt UI integrates with Nuxt Fonts to provide plug-and-play font optimization.",
    icon: "i-lucide-a-large-small",
    to: "/docs/getting-started/integrations/fonts",
  },
  {
    title: "Color Mode",
    description:
      "Nuxt UI integrates with Nuxt Color Mode to switch between light and dark.",
    icon: "i-lucide-sun-moon",
    to: "/docs/getting-started/integrations/color-mode",
  },
  {
    title: "Color Mode",
    description:
      "Nuxt UI integrates with Nuxt Color Mode to switch between light and dark.",
    icon: "i-lucide-sun-moon",
    to: "/docs/getting-started/integrations/color-mode",
  },
]);
const posts = ref<BlogPostProps[]>([
  {
    title: "Nuxt Icon v1",
    description: "Discover Nuxt Icon v1!",
    image: "https://nuxt.com/assets/blog/nuxt-icon/cover.png",
    date: "2024-11-25",
  },
  {
    title: "Nuxt 3.14",
    description: "Nuxt 3.14 is out!",
    image: "https://nuxt.com/assets/blog/v3.14.png",
    date: "2024-11-04",
  },
  {
    title: "Nuxt 3.13",
    description: "Nuxt 3.13 is out!",
    image: "https://nuxt.com/assets/blog/v3.13.png",
    date: "2024-08-22",
  },
]);

const links = ref<ButtonProps[]>([
  {
    label: "Listen",
    to: "/docs/getting-started",
    icon: "i-lucide-square-play",
  },
]);
//min-h-screen for full cover
</script>

<template>
  <div>
    <UPageHero
      title="Jesus Saves You"
      description="Penatibus pretium id, eros convallis tempor id nunc vel eu, finibus pharetra. Nullam libero nibh diam, tristique, arcu gravida quam diam lorem varius urna. Tempor."
      :links="links"
      :style="{ backgroundImage: `url(${crosswheat})` }"
      class="bg-cover bg-center"
      orientation="horizontal"
    />
    <UPageSection
      title="About Us"
      description="Ut congue platea eu a, eu ultrices, pulvinar quam lectus pulvinar porta. Tortor vitae, amet nulla, orci vestibulum purus ullamcorper odio tortor neque dolor. Tincidunt nullam dui at lacus sed."
      :features="features"
      :ui="{
        features: 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8',
      }"
      class="bg-gray-100"
    />
    <USeparator />
    <div class="bg-amber-300/50">
      <UPageSection
        title="Sermon"
        :style="{ backgroundImage: `url(${sermon})` }"
        description="Dolor, mi in, justo tortor turpis aliquet pulvinar varius varius purus aenean. Ac, sed, morbi purus ut imperdiet platea rhoncus iaculis urna lacus arcu. Euismod, duis, tortor turpis donec tempus."
        class="bg-center bg-cover"
      >
        <UPageCTA
          title="Last Sermon title"
          description="We've built a strong, lasting partnership. Their trust is our driving force, propelling us towards shared success."
          orientation="horizontal"
          :links="links"
          class="bg-gray-100"
        >
          <div class="w-[320px] h-91 border">
            <img
              src="https://picsum.photos/640/728"
              width="320"
              height="364"
              alt="Illustration"
              class="w-full"
            />
          </div>
        </UPageCTA>
      </UPageSection>
    </div>

    <UPageSection
      title="Upcoming Events"
      description="Lectus, et tristique, dui ipsum tincidunt vitae laoreet elementum eu at volutpat. Et a mi, etiam montes dapibus diam lectus metus, vel nibh nibh. Suspendisse, vitae, efficitur lectus fermentum lacus vestibulum vulputate varius sit pulvinar."
    >
      <UContainer>
        <div class="space-y-8">
          <UPageCard
            title="Tailwind CSS"
            description="Nuxt UI integrates with latest Tailwind CSS, bringing significant improvements."
            icon="i-simple-icons-tailwindcss"
            orientation="horizontal"
            reverse
            spotlight
            spotlight-color="success"
            to="/"
            target="_blank"
          >
            <img
              src="../assets/css/jesus.png"
              alt="Tailwind CSS"
              class="w-full"
            />
          </UPageCard>
          <UPageCard
            title="Tailwind CSS"
            description="Nuxt UI integrates with latest Tailwind CSS, bringing significant improvements."
            icon="i-simple-icons-tailwindcss"
            orientation="horizontal"
            spotlight
            spotlight-color="success"
            to="/"
            target="_blank"
          >
            <img
              src="../assets/css/jesus.png"
              alt="Tailwind CSS"
              class="w-full"
            />
          </UPageCard>
          <UPageCard
            title="Tailwind CSS"
            description="Nuxt UI integrates with latest Tailwind CSS, bringing significant improvements."
            icon="i-simple-icons-tailwindcss"
            orientation="horizontal"
            reverse
            spotlight
            spotlight-color="success"
            to="/"
            target="_blank"
            variant="outline"
          >
            <img
              src="../assets/css/jesus.png"
              alt="Tailwind CSS"
              class="w-full"
            />
          </UPageCard>
        </div>
      </UContainer>
    </UPageSection>
    <USeparator />
    <USeparator />
    <UPageSection
      title="Latest News"
      description="Lobortis nibh, imperdiet, vulputate dictumst ex tempor consequat aenean auctor metus et. Morbi penatibus, magna dui est volutpat eget convallis turpis dis congue vulputate. Ante, nulla luctus nullam eget, suspendisse."
      class="bg-gray-100"
    >
      <div>
        <UBlogPosts :posts="posts2" />
      </div>
    </UPageSection>
  </div>
</template>
