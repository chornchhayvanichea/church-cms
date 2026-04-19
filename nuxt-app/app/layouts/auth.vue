<script setup lang="ts">
useHead({
  link: [
    { rel: "preconnect", href: "https://fonts.googleapis.com" },
    {
      rel: "stylesheet",
      href: "https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap",
    },
  ],
});
</script>

<template>
  <div class="min-h-screen flex">
    <!-- Left panel: branding -->
    <div
      class="hidden lg:flex lg:w-[44%] xl:w-[40%] relative flex-col items-center justify-between overflow-hidden bg-[#0c0c0c]"
    >
      <!-- Dot grid -->
      <div
        class="absolute inset-0 opacity-[0.035]"
        style="
          background-image: radial-gradient(
            circle,
            #ffffff 1px,
            transparent 1px
          );
          background-size: 28px 28px;
        "
      />
      <!-- Warm radial glow -->
      <div
        class="absolute inset-0 bg-[radial-gradient(ellipse_at_30%_60%,_rgba(180,140,60,0.08)_0%,_transparent_65%)]"
      />

      <!-- Decorative arcs top-right -->
      <svg
        class="absolute top-0 right-0 w-72 h-72 opacity-[0.06]"
        viewBox="0 0 300 300"
        fill="none"
      >
        <circle cx="300" cy="0" r="260" stroke="#c9a96e" stroke-width="0.8" />
        <circle cx="300" cy="0" r="200" stroke="#c9a96e" stroke-width="0.8" />
        <circle cx="300" cy="0" r="140" stroke="#c9a96e" stroke-width="0.8" />
      </svg>
      <!-- Decorative arcs bottom-left -->
      <svg
        class="absolute bottom-0 left-0 w-56 h-56 opacity-[0.06]"
        viewBox="0 0 240 240"
        fill="none"
      >
        <circle cx="0" cy="240" r="200" stroke="#c9a96e" stroke-width="0.8" />
        <circle cx="0" cy="240" r="140" stroke="#c9a96e" stroke-width="0.8" />
      </svg>

      <!-- Center content -->
      <div
        class="relative z-10 flex flex-col items-center text-center px-12 mt-auto mb-auto"
      >
        <!-- Cross -->
        <svg
          class="mb-10"
          width="36"
          height="48"
          viewBox="0 0 36 48"
          fill="none"
        >
          <rect
            x="13"
            y="0"
            width="10"
            height="48"
            rx="1.5"
            fill="#c9a96e"
            opacity="0.75"
          />
          <rect
            x="0"
            y="14"
            width="36"
            height="10"
            rx="1.5"
            fill="#c9a96e"
            opacity="0.75"
          />
        </svg>

        <LogoComponent class="h-8 w-auto mb-7 opacity-80" />

        <h1
          class="text-white text-[2.6rem] font-medium leading-tight mb-4"
          style="
            font-family: &quot;Cormorant Garamond&quot;, serif;
            letter-spacing: 0.015em;
          "
        >
          Jesus Saves You Church
        </h1>

        <!-- Golden rule -->
        <div class="flex items-center gap-3 mb-4">
          <div class="h-px w-10 bg-[#c9a96e] opacity-50" />
          <div class="w-1 h-1 rounded-full bg-[#c9a96e] opacity-50" />
          <div class="h-px w-10 bg-[#c9a96e] opacity-50" />
        </div>

        <p
          class="text-white/35 text-[0.7rem] tracking-[0.18em] uppercase"
          style="font-family: &quot;DM Sans&quot;, sans-serif; font-weight: 300"
        >
          Where faith meets community
        </p>
      </div>

      <!-- Bottom scripture -->
      <div class="relative z-10 pb-10 px-12 text-center">
        <p
          class="text-white/20 text-sm italic"
          style="font-family: &quot;Cormorant Garamond&quot;, serif"
        >
          "I am the way, the truth, and the life."
        </p>
        <p
          class="text-white/15 text-[0.65rem] mt-1.5 tracking-[0.12em] uppercase"
          style="font-family: &quot;DM Sans&quot;, sans-serif; font-weight: 300"
        >
          John 14:6
        </p>
      </div>
    </div>

    <!-- Right panel: form slot -->
    <div
      class="flex-1 flex flex-col items-center justify-center bg-[#f9f9f7] dark:bg-[#111] px-6 py-12 lg:px-16"
    >
      <!-- Mobile header -->
      <div class="lg:hidden flex flex-col items-center mb-10">
        <div class="mb-3 p-2.5 rounded-xl bg-[#0c0c0c]">
          <LogoComponent class="h-7 w-auto" />
        </div>
        <p
          class="text-gray-900 dark:text-white text-xl font-medium"
          style="font-family: &quot;Cormorant Garamond&quot;, serif"
        >
          Jesus Saves You
        </p>
      </div>

      <slot />
    </div>
  </div>
</template>
