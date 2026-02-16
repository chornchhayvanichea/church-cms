<script setup lang="ts">
import { ref } from "vue";
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
</script>

<template>
  <div class="overflow-hidden">
    <!-- HERO SECTION -->
    <UPageHero
      title="Contact"
      class="bg-cover bg-center bg-fixed min-h-[50%]"
      :style="{
        backgroundImage: `linear-gradient(rgba(255,255 , 255, 0.2), rgba(0, 0, 0, 0.5)), url(${churchBuilding})`,
      }"
    />

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
            <UInput placeholder="Name" size="big" />
          </UFormField>
          <UFormField>
            <UInput placeholder="Email" size="big" />
          </UFormField>
          <UFormField>
            <UInput placeholder="Subject" size="big" />
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
  </div>
</template>
