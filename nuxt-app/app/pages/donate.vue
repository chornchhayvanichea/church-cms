<script setup lang="ts">
import donateBg from "~/assets/images/crosswheat.jpg";

useHead({ title: "Donate" });

const { settings } = await usePublicSettings();
</script>

<template>
  <div>
    <!-- Hero -->
    <div
      class="relative min-h-[42vh] flex items-center justify-center bg-[#0c0c0c] bg-cover bg-center overflow-hidden"
      :style="{ backgroundImage: `url(${donateBg})` }"
    >
      <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/40 to-black/70" />
      <div class="relative z-10 text-center px-6 pt-16 pb-12">
        <div class="flex items-center justify-center gap-3 mb-5">
          <div class="h-px w-8 bg-[#c9a96e] opacity-60" />
          <p class="text-[#c9a96e] text-[0.65rem] font-medium tracking-[0.25em] uppercase opacity-80">
            Support Our Mission
          </p>
          <div class="h-px w-8 bg-[#c9a96e] opacity-60" />
        </div>
        <h1
          class="text-white leading-none mb-4"
          style="font-family: 'Cormorant Garamond', serif; font-size: clamp(3.5rem, 8vw, 5.5rem); font-weight: 500; letter-spacing: -0.02em;"
        >
          Give
        </h1>
        <p class="text-white/60 text-base sm:text-lg leading-relaxed max-w-lg mx-auto" style="font-weight: 300;">
          Your generosity helps us serve our community, share the gospel, and grow together in faith.
        </p>
      </div>
    </div>

    <UContainer class="max-w-5xl py-16 sm:py-20">
      <!-- Giving methods -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Bank Transfer -->
        <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-7 flex flex-col gap-5">
          <div class="w-11 h-11 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center shrink-0">
            <UIcon name="i-lucide-landmark" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
          </div>
          <div>
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Bank Transfer</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
              Send a direct transfer to our church account.
            </p>
          </div>
          <div class="space-y-3 pt-1">
            <div class="flex flex-col gap-0.5">
              <span class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Bank</span>
              <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ settings.donate_bank_name || '—' }}</span>
            </div>
            <div class="flex flex-col gap-0.5">
              <span class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Account Name</span>
              <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ settings.donate_account_name || '—' }}</span>
            </div>
            <div class="flex flex-col gap-0.5">
              <span class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Account No.</span>
              <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ settings.donate_account_no || '—' }}</span>
            </div>
            <div class="flex flex-col gap-0.5">
              <span class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Routing No.</span>
              <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ settings.donate_routing_no || '—' }}</span>
            </div>
          </div>
        </div>

        <!-- Give Online (highlighted) -->
        <div class="rounded-xl border-2 border-gray-900 dark:border-white bg-white dark:bg-gray-900 p-7 flex flex-col gap-5 relative">
          <div class="absolute -top-3 left-1/2 -translate-x-1/2">
            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-bold bg-gray-900 dark:bg-white text-white dark:text-gray-900">
              Recommended
            </span>
          </div>
          <div class="w-11 h-11 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center shrink-0">
            <UIcon name="i-lucide-smartphone" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
          </div>
          <div>
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Give Online</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
              Quick and secure giving through our online platform.
            </p>
          </div>
          <div class="mt-auto pt-2">
            <UButton
              v-if="settings.donate_online_url"
              as="a"
              :href="settings.donate_online_url"
              target="_blank"
              rel="noopener noreferrer"
              size="md"
              class="w-full justify-center"
              trailing-icon="i-lucide-external-link"
            >
              {{ settings.donate_online_label || 'Give Online' }}
            </UButton>
            <p v-else class="text-sm text-gray-400 dark:text-gray-500 italic">
              Online giving link not configured yet.
            </p>
          </div>
        </div>

        <!-- Give in Person -->
        <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-7 flex flex-col gap-5">
          <div class="w-11 h-11 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center shrink-0">
            <UIcon name="i-lucide-church" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
          </div>
          <div>
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Give in Person</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
              Drop your gift in the offering during any of our services.
            </p>
          </div>
          <div class="space-y-3 pt-1">
            <div class="flex flex-col gap-0.5">
              <span class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Service</span>
              <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ settings.church_service_time || '—' }}</span>
            </div>
            <div class="flex flex-col gap-0.5">
              <span class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Address</span>
              <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ settings.church_address || '—' }}</span>
            </div>
            <div class="flex flex-col gap-0.5">
              <span class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">City</span>
              <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ settings.church_city || '—' }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Scripture -->
      <div class="mt-16 border-l-[3px] border-amber-400 pl-6 max-w-2xl mx-auto">
        <blockquote class="text-xl sm:text-2xl font-medium text-gray-700 dark:text-gray-300 leading-relaxed mb-3">
          "Each of you should give what you have decided in your heart to give, not reluctantly or under compulsion, for God loves a cheerful giver."
        </blockquote>
        <p class="text-sm font-semibold text-amber-600 dark:text-amber-400">2 Corinthians 9:7</p>
      </div>

      <!-- Questions note -->
      <p class="text-sm text-gray-400 dark:text-gray-500 mt-14 text-center">
        Questions about giving?
        <NuxtLink
          to="/contact"
          class="font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white underline underline-offset-2 transition-colors"
        >
          Contact us
        </NuxtLink>
      </p>
    </UContainer>
  </div>
</template>
