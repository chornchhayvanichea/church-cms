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
  <footer class="bg-amber-950 text-white">
    <UContainer class="py-12 sm:py-16">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
        <!-- Brand -->
        <div class="lg:col-span-1 space-y-3">
          <h2 class="font-bold text-lg text-white">
            {{ settings.site_name || 'Church Name' }}
          </h2>
          <p class="text-sm text-white/60 leading-relaxed">
            {{ settings.footer_description || settings.site_tagline || 'A community built on faith, hope, and love.' }}
          </p>
        </div>

        <!-- Quick Links -->
        <div class="space-y-3">
          <h3 class="text-xs font-bold uppercase tracking-widest text-white/40">Quick Links</h3>
          <ul class="space-y-2">
            <li v-for="link in quickLinks" :key="link.label">
              <NuxtLink :to="link.to" class="text-sm text-white/70 hover:text-white transition-colors">
                {{ link.label }}
              </NuxtLink>
            </li>
          </ul>
        </div>

        <!-- Contact -->
        <div class="space-y-3">
          <h3 class="text-xs font-bold uppercase tracking-widest text-white/40">Contact Us</h3>
          <ul class="space-y-2 text-sm text-white/70">
            <li v-if="settings.church_address" class="flex items-start gap-2">
              <UIcon name="i-lucide-map-pin" class="w-4 h-4 mt-0.5 shrink-0 text-amber-400" />
              <span>{{ settings.church_address }}<span v-if="settings.church_city">, {{ settings.church_city }}</span></span>
            </li>
            <li v-if="settings.church_phone">
              <a :href="`tel:${settings.church_phone}`" class="flex items-center gap-2 hover:text-white transition-colors">
                <UIcon name="i-lucide-phone" class="w-4 h-4 shrink-0 text-amber-400" />
                {{ settings.church_phone }}
              </a>
            </li>
            <li v-if="settings.church_email">
              <a :href="`mailto:${settings.church_email}`" class="flex items-center gap-2 hover:text-white transition-colors">
                <UIcon name="i-lucide-mail" class="w-4 h-4 shrink-0 text-amber-400" />
                {{ settings.church_email }}
              </a>
            </li>
            <li v-if="settings.church_service_time" class="flex items-center gap-2">
              <UIcon name="i-lucide-clock" class="w-4 h-4 shrink-0 text-amber-400" />
              {{ settings.church_service_time }}
            </li>
          </ul>
        </div>

        <!-- Give -->
        <div class="space-y-3">
          <h3 class="text-xs font-bold uppercase tracking-widest text-white/40">More</h3>
          <ul class="space-y-2">
            <li>
              <NuxtLink to="/donate" class="text-sm text-white/70 hover:text-white transition-colors">
                Donate
              </NuxtLink>
            </li>
            <li>
              <NuxtLink :to="DASHBOARD_ROUTES.AUTH_LOGIN" class="text-sm text-white/70 hover:text-white transition-colors">
                Staff Login
              </NuxtLink>
            </li>
          </ul>
        </div>
      </div>
    </UContainer>

    <div class="border-t border-white/10">
      <UContainer class="py-4">
        <p class="text-[11px] text-white/30">
          Copyright © {{ new Date().getFullYear() }} {{ settings.site_name || 'Church Name' }}. All rights reserved.
        </p>
      </UContainer>
    </div>
  </footer>
</template>
