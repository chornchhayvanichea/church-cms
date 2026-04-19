<script setup lang="ts">
import churchBuilding from "../assets/images/crosswheat.jpg";

useHead({ title: "Contact Us" });

const { settings } = await usePublicSettings();

const form = reactive({ name: "", email: "", subject: "", message: "" });
const submitting = ref(false);
const submitted = ref(false);
const error = ref("");

const toast = useToast();

const submit = async () => {
  submitting.value = true;
  error.value = "";
  try {
    const { api } = await import("~/services/axios");
    await api.post("/api/public/contact", form);
    submitted.value = true;
    toast.add({ title: "Message sent!", description: "We'll get back to you soon.", color: "success", icon: "i-lucide-check-circle" });
    Object.assign(form, { name: "", email: "", subject: "", message: "" });
  } catch {
    error.value = "Something went wrong. Please try again.";
  } finally {
    submitting.value = false;
  }
};
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
          <p class="text-[#c9a96e] text-[0.65rem] font-medium tracking-[0.25em] uppercase opacity-80">Get in Touch</p>
          <div class="h-px w-8 bg-[#c9a96e] opacity-60" />
        </div>
        <h1
          class="text-white leading-none"
          style="font-family: 'Cormorant Garamond', serif; font-size: clamp(3rem, 8vw, 5rem); font-weight: 500; letter-spacing: -0.02em;"
        >
          Contact
        </h1>
        <p class="text-white/55 text-base leading-relaxed mt-3 max-w-lg" style="font-weight: 300;">
          Have a question or need prayer? We'd love to hear from you.
        </p>
      </div>
    </div>

    <UPageSection
      title="Send Us a Message"
      headline="Get in Touch"
      description="Have a question or need prayer? Fill out the form below and we'll get back to you as soon as possible."
      class="bg-gray-100 dark:bg-gray-900"
    >
      <div class="grid lg:grid-cols-2 gap-12 max-w-5xl mx-auto">
        <!-- Form -->
        <form class="space-y-4" @submit.prevent="submit">
          <UFormField label="Name" required>
            <UInput v-model="form.name" placeholder="Your name" class="w-full" />
          </UFormField>
          <UFormField label="Email" required>
            <UInput v-model="form.email" type="email" placeholder="your@email.com" class="w-full" />
          </UFormField>
          <UFormField label="Subject">
            <UInput v-model="form.subject" placeholder="What's this about?" class="w-full" />
          </UFormField>
          <UFormField label="Message" required>
            <UTextarea v-model="form.message" placeholder="Your message..." :rows="6" class="w-full" />
          </UFormField>
          <p v-if="error" class="text-sm text-red-500">{{ error }}</p>
          <UButton type="submit" :loading="submitting" size="lg" icon="i-lucide-send">
            Send Message
          </UButton>
        </form>

        <!-- Contact info -->
        <div class="space-y-8">
          <div class="space-y-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Contact Information</h3>
            <div class="space-y-3">
              <div v-if="settings.church_address" class="flex items-start gap-3 text-sm text-gray-600 dark:text-gray-400">
                <UIcon name="i-lucide-map-pin" class="w-4 h-4 mt-0.5 shrink-0 text-amber-600" />
                <span>{{ settings.church_address }}, {{ settings.church_city }}</span>
              </div>
              <div v-if="settings.church_phone" class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                <UIcon name="i-lucide-phone" class="w-4 h-4 shrink-0 text-amber-600" />
                <a :href="`tel:${settings.church_phone}`" class="hover:text-gray-900 dark:hover:text-white transition-colors">
                  {{ settings.church_phone }}
                </a>
              </div>
              <div v-if="settings.church_email" class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                <UIcon name="i-lucide-mail" class="w-4 h-4 shrink-0 text-amber-600" />
                <a :href="`mailto:${settings.church_email}`" class="hover:text-gray-900 dark:hover:text-white transition-colors">
                  {{ settings.church_email }}
                </a>
              </div>
            </div>
          </div>

          <div class="space-y-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Service Times</h3>
            <div class="space-y-3">
              <div v-if="settings.contact_service_1_name" class="flex justify-between text-sm border-b border-gray-200 dark:border-gray-700 pb-2">
                <span class="font-medium text-gray-700 dark:text-gray-300">{{ settings.contact_service_1_name }}</span>
                <span class="text-gray-500 dark:text-gray-400">{{ settings.contact_service_1_time }}</span>
              </div>
              <div v-if="settings.contact_service_2_name" class="flex justify-between text-sm border-b border-gray-200 dark:border-gray-700 pb-2">
                <span class="font-medium text-gray-700 dark:text-gray-300">{{ settings.contact_service_2_name }}</span>
                <span class="text-gray-500 dark:text-gray-400">{{ settings.contact_service_2_time }}</span>
              </div>
            </div>
          </div>

          <div class="w-full h-56 bg-gray-200 dark:bg-gray-800 rounded-xl overflow-hidden">
            <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
              <div class="text-center">
                <UIcon name="i-lucide-map" class="w-10 h-10 mx-auto mb-2" />
                <p class="text-sm">{{ settings.church_address || 'Map placeholder' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </UPageSection>
  </div>
</template>
