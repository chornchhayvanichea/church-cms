<script setup lang="ts">
import { ref } from "vue";
import type { ButtonProps } from "@nuxt/ui";
import churchBuilding from "../assets/images/crosswheat.jpg";

// Page metadata
useHead({
  title: "Contact Us",
  meta: [
    {
      name: "description",
      content:
        "Get in touch with us. We'd love to hear from you and answer any questions.",
    },
  ],
});

// Contact information
const contactInfo = [
  {
    icon: "i-lucide-map-pin",
    label: "Address",
    value: "123 Church Street, Your City, ST 12345",
  },
  {
    icon: "i-lucide-phone",
    label: "Phone",
    value: "(555) 123-4567",
    link: "tel:+15551234567",
  },
  {
    icon: "i-lucide-mail",
    label: "Email",
    value: "info@church.com",
    link: "mailto:info@church.com",
  },
];

// Service times
const serviceTimes = [
  {
    day: "Sunday",
    services: [
      { time: "9:00 AM", type: "Traditional Service" },
      { time: "11:00 AM", type: "Contemporary Service" },
    ],
  },
  {
    day: "Wednesday",
    services: [{ time: "7:00 PM", type: "Bible Study & Prayer" }],
  },
];

// Form state
const formData = ref({
  name: "",
  email: "",
  phone: "",
  message: "",
});

const handleSubmit = () => {
  // Handle form submission logic here
  console.log("Form submitted:", formData.value);
  // You can add actual form submission logic later
};
</script>

<template>
  <div class="overflow-hidden">
    <!-- HERO SECTION -->
    <UPageHero
      title="Get In Touch"
      description="We'd love to hear from you. Whether you have questions, prayer requests, or just want to say hello, reach out to us."
      :style="{ backgroundImage: `url(${churchBuilding})` }"
      class="bg-cover bg-center"
      orientation="horizontal"
    />

    <!-- CONTACT INFORMATION SECTION -->
    <UPageSection
      title="Contact Information"
      headline="Reach Out"
      description="Feel free to contact us using any of the methods below. We're here to help and answer any questions you may have."
    >
      <div class="grid sm:grid-cols-3 gap-8 max-w-4xl mx-auto">
        <div
          v-for="info in contactInfo"
          :key="info.label"
          class="bg-white p-6 rounded-lg shadow-sm text-center"
        >
          <div class="flex justify-center mb-4">
            <div
              class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center"
            >
              <UIcon :name="info.icon" class="w-6 h-6 text-amber-600" />
            </div>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">
            {{ info.label }}
          </h3>
          <a
            v-if="info.link"
            :href="info.link"
            class="text-gray-600 hover:text-amber-600 transition-colors"
          >
            {{ info.value }}
          </a>
          <p v-else class="text-gray-600">{{ info.value }}</p>
        </div>
      </div>
    </UPageSection>

    <!-- CONTACT FORM & MAP SECTION -->
    <UPageSection
      title="Send Us a Message"
      headline="Contact Form"
      description="Have a question or need prayer? Fill out the form below and we'll get back to you as soon as possible."
      class="bg-gray-100"
    >
      <div class="grid lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
        <!-- Contact Form -->
        <div class="space-y-4">
          <UFormField>
            <UInput placeholder="Enter your email" size="big" />
          </UFormField>
          <UFormField>
            <UInput placeholder="Enter your name" size="big" />
          </UFormField>
          <UFormField>
            <UInput placeholder="Enter your Subject" size="big" />
          </UFormField>
          <UFormField>
            <UTextarea placeholder="Enter your message" :cols="43" :rows="7" />
          </UFormField>
          <UButton class="mt-3" size="xl" :ui="{ base: 'rounded-none' }">
            Send message
          </UButton>
        </div>
        <!-- Map -->

        <div
          class="w-full h-full min-h-96 bg-gray-300 rounded-lg overflow-hidden shadow-lg"
        >
          <!-- Replace this div with actual map embed (Google Maps, etc.) -->
          <div
            class="w-full h-full flex items-center justify-center text-gray-500"
          >
            <div class="text-center">
              <UIcon name="i-lucide-map" class="w-16 h-16 mx-auto mb-4" />
              <p>Map will be embedded here</p>
              <p class="text-sm mt-2">123 Church Street, Your City, ST 12345</p>
            </div>
          </div>
        </div>
      </div>
    </UPageSection>

    <!-- SERVICE TIMES SECTION -->
    <UPageSection
      title="Service Times"
      headline="Join Us"
      description="All are welcome to join us for worship and fellowship. We look forward to seeing you!"
    >
      <div class="grid sm:grid-cols-2 gap-8 max-w-3xl mx-auto">
        <div
          v-for="schedule in serviceTimes"
          :key="schedule.day"
          class="bg-white p-8 rounded-lg shadow-sm"
        >
          <div class="flex items-center gap-3 mb-4">
            <UIcon name="i-lucide-calendar" class="w-6 h-6 text-amber-600" />
            <h3 class="text-xl font-bold text-gray-900">{{ schedule.day }}</h3>
          </div>
          <div class="space-y-2">
            <div
              v-for="service in schedule.services"
              :key="service.time"
              class="text-gray-600"
            >
              <span class="font-semibold">{{ service.time }}</span> -
              {{ service.type }}
            </div>
          </div>
        </div>
      </div>
    </UPageSection>

    <!-- CTA SECTION -->
    <UPageCTA
      title="New Here?"
      description="We'd love to welcome you this Sunday! No matter where you are in your faith journey, you belong here."
    />
  </div>
</template>
