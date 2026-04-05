<template>
  <UModal v-model:open="isOpen">
    <template #content>
      <div class="p-6 space-y-4">
        <p>{{ message }}</p>
        <div class="flex gap-2 justify-end">
          <UButton color="neutral" variant="subtle" @click="isOpen = false"
            >Cancel</UButton
          >
          <UButton color="error" @click="confirm">Delete</UButton>
        </div>
      </div>
    </template>
  </UModal>
</template>
<script setup lang="ts">
const props = defineProps<{
  message?: string;
}>();

const emit = defineEmits<{
  confirm: [];
}>();

const isOpen = defineModel<boolean>({ default: false });

const confirm = () => {
  emit("confirm");
  isOpen.value = false;
};
</script>
