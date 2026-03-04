<template>
  <div class="p-40">
    <form @submit.prevent="handleSignUp">
      <input v-model="formdata.name" type="text" placeholder="name" />
      <br />
      <br />
      <input v-model="formdata.email" type="email" placeholder="email" />
      <br />
      <br />
      <input
        v-model="formdata.password"
        type="password"
        placeholder="password"
      />
      <br />
      <br />
      <button>submit</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import type { SignupData } from "~/types/authTypes";
definePageMeta({
  layout: "auth",
});
const authStore = useAuthStore();
const formdata = ref<SignupData>({
  name: "",
  email: "",
  password: "",
});
const handleSignUp = async () => {
  await authStore.signup(formdata.value);
};
</script>

<style scoped></style>
