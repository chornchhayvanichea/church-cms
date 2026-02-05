import auth from "/home/chea/personal-project/church-cms/nuxt-app/app/layouts/auth.vue";
import dashboard from "/home/chea/personal-project/church-cms/nuxt-app/app/layouts/dashboard.vue";
import type { ComputedRef, MaybeRef } from 'vue'
declare module 'nuxt/app' {
  interface NuxtLayouts {
    'auth': InstanceType<typeof auth>['$props'],
    'dashboard': InstanceType<typeof dashboard>['$props'],
}
  export type LayoutKey = keyof NuxtLayouts extends never ? string : keyof NuxtLayouts
  interface PageMeta {
    layout?: MaybeRef<LayoutKey | false> | ComputedRef<LayoutKey | false>
  }
}