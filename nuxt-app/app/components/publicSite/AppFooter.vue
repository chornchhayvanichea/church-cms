<script setup lang="ts">
import { DASHBOARD_ROUTES } from "~/constants/routes";

const settingStore = useSettingStore();
const { settings } = storeToRefs(settingStore);

const quickLinks = [
  { label: "Home", to: "/" },
  { label: "About", to: "/about" },
  { label: "Sermons", to: "/sermons" },
  { label: "Events", to: "/events" },
  { label: "Blog", to: "/blogs" },
  { label: "Contact", to: "/contact" },
];
</script>

<template>
  <footer class="relative bg-[#0c0c0c] text-white overflow-hidden">
    <!-- Subtle dot grid -->
    <div
      class="absolute inset-0 opacity-[0.03]"
      style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 28px 28px;"
    />
    <!-- Warm glow -->
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[600px] h-64 bg-[radial-gradient(ellipse,_rgba(180,140,60,0.06)_0%,_transparent_70%)]" />

    <div class="relative max-w-7xl mx-auto px-5 sm:px-8 pt-14 pb-10 sm:pt-16 sm:pb-12">
      <!-- Top: brand + cols -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12 pb-12 border-b border-white/8">

        <!-- Brand -->
        <div class="lg:col-span-1 space-y-4">
          <div class="flex items-center gap-2.5">
            <div class="p-1.5 rounded-md bg-white/8">
              <LogoComponent class="h-5 w-auto" />
            </div>
            <span
              class="text-base font-medium text-white"
              style="font-family: 'Cormorant Garamond', serif; letter-spacing: 0.01em;"
            >
              {{ settings.site_name || 'Grace Church' }}
            </span>
          </div>
          <p class="text-sm text-white/45 leading-relaxed">
            {{ settings.footer_description || settings.site_tagline || 'A community built on faith, hope, and love.' }}
          </p>
          <!-- Golden rule -->
          <div class="flex items-center gap-2 pt-1">
            <div class="h-px w-8 bg-[#c9a96e] opacity-50" />
            <svg width="10" height="14" viewBox="0 0 10 14" fill="none" class="opacity-50">
              <rect x="3.5" y="0" width="3" height="14" rx="0.5" fill="#c9a96e" />
              <rect x="0" y="4" width="10" height="3" rx="0.5" fill="#c9a96e" />
            </svg>
            <div class="h-px w-8 bg-[#c9a96e] opacity-50" />
          </div>
        </div>

        <!-- Quick Links -->
        <div class="space-y-4">
          <h3 class="text-[10px] font-semibold uppercase tracking-[0.18em] text-white/30">
            Quick Links
          </h3>
          <ul class="space-y-2.5">
            <li v-for="link in quickLinks" :key="link.label">
              <NuxtLink
                :to="link.to"
                class="text-sm text-white/55 hover:text-white transition-colors duration-150"
              >
                {{ link.label }}
              </NuxtLink>
            </li>
          </ul>
        </div>

        <!-- Contact -->
        <div class="space-y-4">
          <h3 class="text-[10px] font-semibold uppercase tracking-[0.18em] text-white/30">
            Contact Us
          </h3>
          <ul class="space-y-3 text-sm text-white/55">
            <li v-if="settings.church_address" class="flex items-start gap-2.5">
              <UIcon name="i-lucide-map-pin" class="w-3.5 h-3.5 mt-0.5 shrink-0 text-[#c9a96e] opacity-80" />
              <span>{{ settings.church_address }}<span v-if="settings.church_city">, {{ settings.church_city }}</span></span>
            </li>
            <li v-if="settings.church_phone">
              <a :href="`tel:${settings.church_phone}`" class="flex items-center gap-2.5 hover:text-white transition-colors">
                <UIcon name="i-lucide-phone" class="w-3.5 h-3.5 shrink-0 text-[#c9a96e] opacity-80" />
                {{ settings.church_phone }}
              </a>
            </li>
            <li v-if="settings.church_email">
              <a :href="`mailto:${settings.church_email}`" class="flex items-center gap-2.5 hover:text-white transition-colors">
                <UIcon name="i-lucide-mail" class="w-3.5 h-3.5 shrink-0 text-[#c9a96e] opacity-80" />
                {{ settings.church_email }}
              </a>
            </li>
            <li v-if="settings.church_service_time" class="flex items-center gap-2.5">
              <UIcon name="i-lucide-clock" class="w-3.5 h-3.5 shrink-0 text-[#c9a96e] opacity-80" />
              {{ settings.church_service_time }}
            </li>
          </ul>
        </div>

        <!-- More -->
        <div class="space-y-4">
          <h3 class="text-[10px] font-semibold uppercase tracking-[0.18em] text-white/30">
            More
          </h3>
          <ul class="space-y-2.5">
            <li>
              <NuxtLink to="/donate" class="text-sm text-white/55 hover:text-white transition-colors duration-150">
                Donate
              </NuxtLink>
            </li>
            <li>
              <NuxtLink :to="DASHBOARD_ROUTES.AUTH_LOGIN" class="text-sm text-white/55 hover:text-white transition-colors duration-150">
                Staff Login
              </NuxtLink>
            </li>
          </ul>
        </div>
      </div>

      <!-- Bottom bar -->
      <div class="pt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <p class="text-[11px] text-white/25 tracking-wide">
          © {{ new Date().getFullYear() }} {{ settings.site_name || 'Grace Church' }}. All rights reserved.
        </p>
        <p class="text-[11px] text-white/15 italic" style="font-family: 'Cormorant Garamond', serif;">
          "For God so loved the world..." — John 3:16
        </p>
      </div>
    </div>
  </footer>
</template>
