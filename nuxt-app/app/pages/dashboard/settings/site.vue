<script setup lang="ts">
import type { Settings } from "~/types/settingTypes";

definePageMeta({ layout: "dashboard", middleware: "dashboard" });

const settingStore = useSettingStore();
const { settings, saving } = storeToRefs(settingStore);

await useAsyncData("dashboard-settings", () => settingStore.getPublicSettings());

const form = reactive<Settings>({ ...settings.value });
watch(settings, (val) => Object.assign(form, val));

const toast = useToast();
const submit = async () => {
  const ok = await settingStore.saveSettings(form);
  if (ok) toast.add({ title: "Settings saved.", color: "success", icon: "i-lucide-check-circle" });
  else toast.add({ title: "Failed to save.", color: "error", icon: "i-lucide-x-circle" });
};

const tabs = [
  { label: "Site & Contact", icon: "i-lucide-building-2", slot: "site" },
  { label: "Homepage", icon: "i-lucide-house", slot: "home" },
  { label: "About", icon: "i-lucide-info", slot: "about" },
  { label: "Pages", icon: "i-lucide-file-text", slot: "pages" },
  { label: "Donation", icon: "i-lucide-heart-handshake", slot: "donation" },
];
</script>

<template>
  <div class="max-w-2xl space-y-6">
    <div>
      <h1 class="text-xl font-bold text-gray-900 dark:text-white">Site Settings</h1>
      <p class="text-sm text-gray-500 mt-1">Manage your church's public content and information.</p>
    </div>

    <form @submit.prevent="submit">
      <UTabs :items="tabs" class="w-full">
        <!-- Site & Contact -->
        <template #site>
          <div class="space-y-5 pt-6">
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Site</h2>
              <UFormField label="Site Name">
                <UInput v-model="form.site_name" placeholder="Church Name" class="w-full" />
              </UFormField>
              <UFormField label="Tagline">
                <UInput v-model="form.site_tagline" placeholder="A community built on faith..." class="w-full" />
              </UFormField>
            </div>
            <USeparator />
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Contact & Location</h2>
              <UFormField label="Address">
                <UInput v-model="form.church_address" placeholder="123 Church Street" class="w-full" />
              </UFormField>
              <UFormField label="City / State">
                <UInput v-model="form.church_city" placeholder="Your City, State" class="w-full" />
              </UFormField>
              <div class="grid grid-cols-2 gap-4">
                <UFormField label="Phone">
                  <UInput v-model="form.church_phone" placeholder="+1 234 567 890" class="w-full" />
                </UFormField>
                <UFormField label="Email">
                  <UInput v-model="form.church_email" type="email" placeholder="hello@church.com" class="w-full" />
                </UFormField>
              </div>
              <UFormField label="Service Time (general)">
                <UInput v-model="form.church_service_time" placeholder="Sunday 10:00 AM" class="w-full" />
              </UFormField>
            </div>
            <USeparator />
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Service Schedule (Contact Page)</h2>
              <div class="grid grid-cols-2 gap-4">
                <UFormField label="Service 1 Name">
                  <UInput v-model="form.contact_service_1_name" placeholder="Sunday Morning" class="w-full" />
                </UFormField>
                <UFormField label="Service 1 Time">
                  <UInput v-model="form.contact_service_1_time" placeholder="9:00 AM & 11:00 AM" class="w-full" />
                </UFormField>
                <UFormField label="Service 2 Name">
                  <UInput v-model="form.contact_service_2_name" placeholder="Wednesday Evening" class="w-full" />
                </UFormField>
                <UFormField label="Service 2 Time">
                  <UInput v-model="form.contact_service_2_time" placeholder="7:00 PM" class="w-full" />
                </UFormField>
              </div>
            </div>
            <USeparator />
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Footer</h2>
              <UFormField label="Footer Description">
                <UTextarea v-model="form.footer_description" placeholder="A community built on faith..." :rows="2" class="w-full" />
              </UFormField>
            </div>
          </div>
        </template>

        <!-- Homepage -->
        <template #home>
          <div class="space-y-5 pt-6">
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Hero Section</h2>
              <UFormField label="Hero Title">
                <UInput v-model="form.home_hero_title" placeholder="Jesus Saves You" class="w-full" />
              </UFormField>
              <UFormField label="Hero Description">
                <UTextarea v-model="form.home_hero_description" placeholder="A community built on faith..." :rows="3" class="w-full" />
              </UFormField>
            </div>
            <USeparator />
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Stats Bar</h2>
              <div v-for="n in 3" :key="n" class="grid grid-cols-2 gap-4">
                <UFormField :label="`Stat ${n} Number`">
                  <UInput v-model="(form as any)[`home_stat_${n}_number`]" placeholder="500+" class="w-full" />
                </UFormField>
                <UFormField :label="`Stat ${n} Label`">
                  <UInput v-model="(form as any)[`home_stat_${n}_label`]" placeholder="Active Members" class="w-full" />
                </UFormField>
              </div>
            </div>
            <USeparator />
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Ministries</h2>
              <div v-for="n in 4" :key="n" class="space-y-2 pb-4 border-b border-gray-100 dark:border-gray-800 last:border-0">
                <p class="text-xs font-medium text-gray-500">Ministry {{ n }}</p>
                <UFormField :label="`Title`">
                  <UInput v-model="(form as any)[`home_ministry_${n}_title`]" :placeholder="`Ministry ${n} name`" class="w-full" />
                </UFormField>
                <UFormField :label="`Description`">
                  <UTextarea v-model="(form as any)[`home_ministry_${n}_desc`]" :placeholder="`Short description...`" :rows="2" class="w-full" />
                </UFormField>
              </div>
            </div>
            <USeparator />
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Sermon Section</h2>
              <UFormField label="Description">
                <UTextarea v-model="form.home_sermon_section_desc" placeholder="Join us every week..." :rows="2" class="w-full" />
              </UFormField>
            </div>
            <USeparator />
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Bottom CTA</h2>
              <UFormField label="CTA Title">
                <UInput v-model="form.home_cta_title" placeholder="Ready to Join Our Community?" class="w-full" />
              </UFormField>
              <UFormField label="CTA Description">
                <UTextarea v-model="form.home_cta_description" placeholder="We'd love to see you..." :rows="3" class="w-full" />
              </UFormField>
            </div>
          </div>
        </template>

        <!-- About -->
        <template #about>
          <div class="space-y-5 pt-6">
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Mission</h2>
              <UFormField label="Mission Text">
                <UTextarea v-model="form.about_mission_text" placeholder="We exist to glorify God..." :rows="3" class="w-full" />
              </UFormField>
            </div>
            <USeparator />
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Core Values</h2>
              <div v-for="n in 4" :key="n" class="space-y-2 pb-4 border-b border-gray-100 dark:border-gray-800 last:border-0">
                <p class="text-xs font-medium text-gray-500">Value {{ n }}</p>
                <div class="grid grid-cols-2 gap-3">
                  <UFormField label="Title">
                    <UInput v-model="(form as any)[`about_value_${n}_title`]" placeholder="Value title" class="w-full" />
                  </UFormField>
                  <UFormField label="Description">
                    <UInput v-model="(form as any)[`about_value_${n}_desc`]" placeholder="Short description" class="w-full" />
                  </UFormField>
                </div>
              </div>
            </div>
            <USeparator />
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Pastor</h2>
              <div class="grid grid-cols-2 gap-4">
                <UFormField label="Name">
                  <UInput v-model="form.about_pastor_name" placeholder="Pastor John Smith" class="w-full" />
                </UFormField>
                <UFormField label="Title">
                  <UInput v-model="form.about_pastor_title" placeholder="Senior Pastor" class="w-full" />
                </UFormField>
              </div>
              <UFormField label="Photo URL">
                <UInput v-model="form.about_pastor_image" placeholder="https://..." class="w-full" />
              </UFormField>
              <UFormField label="Bio">
                <UTextarea v-model="form.about_pastor_bio" placeholder="Pastor bio..." :rows="4" class="w-full" />
              </UFormField>
            </div>
          </div>
        </template>

        <!-- Pages -->
        <template #pages>
          <div class="space-y-5 pt-6">
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Blog Page</h2>
              <UFormField label="Label (above title)">
                <UInput v-model="form.blogs_hero_label" placeholder="From Our Community" class="w-full" />
              </UFormField>
              <UFormField label="Title">
                <UInput v-model="form.blogs_hero_title" placeholder="Blog" class="w-full" />
              </UFormField>
              <UFormField label="Description">
                <UTextarea v-model="form.blogs_hero_description" placeholder="Thoughts, stories..." :rows="2" class="w-full" />
              </UFormField>
            </div>
            <USeparator />
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Sermons Page</h2>
              <UFormField label="Title">
                <UInput v-model="form.sermons_hero_title" placeholder="Sermons" class="w-full" />
              </UFormField>
              <UFormField label="Description">
                <UTextarea v-model="form.sermons_hero_description" placeholder="Listen to messages..." :rows="2" class="w-full" />
              </UFormField>
            </div>
            <USeparator />
            <div class="space-y-4">
              <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Events Page</h2>
              <UFormField label="Title">
                <UInput v-model="form.events_hero_title" placeholder="Events" class="w-full" />
              </UFormField>
              <UFormField label="Description">
                <UTextarea v-model="form.events_hero_description" placeholder="Gatherings, services..." :rows="2" class="w-full" />
              </UFormField>
            </div>
          </div>
        </template>

        <!-- Donation -->
        <template #donation>
          <div class="space-y-4 pt-6">
            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Bank Transfer</h2>
            <div class="grid grid-cols-2 gap-4">
              <UFormField label="Bank Name">
                <UInput v-model="form.donate_bank_name" placeholder="Your Bank" class="w-full" />
              </UFormField>
              <UFormField label="Account Name">
                <UInput v-model="form.donate_account_name" placeholder="Church Name" class="w-full" />
              </UFormField>
              <UFormField label="Account Number">
                <UInput v-model="form.donate_account_no" placeholder="000-000-0000" class="w-full" />
              </UFormField>
              <UFormField label="Routing Number">
                <UInput v-model="form.donate_routing_no" placeholder="000000000" class="w-full" />
              </UFormField>
            </div>
            <USeparator />
            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Online Giving</h2>
            <div class="grid grid-cols-2 gap-4">
              <UFormField label="Button Label">
                <UInput v-model="form.donate_online_label" placeholder="Give via PayPal" class="w-full" />
              </UFormField>
              <UFormField label="URL">
                <UInput v-model="form.donate_online_url" placeholder="https://paypal.me/..." class="w-full" />
              </UFormField>
            </div>
          </div>
        </template>
      </UTabs>

      <div class="pt-6 border-t border-gray-100 dark:border-gray-800 mt-6">
        <UButton type="submit" :loading="saving" icon="i-lucide-save">
          Save Settings
        </UButton>
      </div>
    </form>
  </div>
</template>
