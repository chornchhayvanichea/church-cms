import {
  getCSRFCookie,
  getUserApi,
  loginApi,
  logoutApi,
} from "~/services/auth";
import type { LoginData } from "~/types/authTypes";
import type { User } from "~/types/userTypes";

export const useAuthStore = defineStore("auth", () => {
  const user = ref<User | null>(null);
  const error = ref<string | null | undefined>(null);
  const loading = ref(false);
  const message = ref<string | null>(null);

  const isLoggedIn = computed(() => user.value != null);

  const isAdmin = computed(() => user.value?.role === "admin");

  const getUser = async () => {
    loading.value = true;
    try {
      const response = await getUserApi();
      user.value = response.data.data;
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };
  const login = async (data: LoginData) => {
    loading.value = true;
    error.value = null;
    try {
      await getCSRFCookie();
      await loginApi(data);
      await getUser();
    } catch (e: any) {
      error.value =
        e?.response?.data?.message ?? "Invalid credentials. Please try again.";
    } finally {
      loading.value = false;
    }
  };
  const logout = async () => {
    await logoutApi();
    user.value = null;
    await navigateTo("/auth/login");
  };
  const values = {
    user,
    error,
    loading,
    message,
    isLoggedIn,
    isAdmin,
    getUser,
    login,
    logout,
  };
  return values;
});
