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

  const isLoggedIn = computed(() => {
    return user.value != null;
  });

  const getUser = async () => {
    loading.value = true;
    try {
      const response = await getUserApi();
      user.value = response.data;
      console.log(user.value);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };
  const login = async (data: LoginData) => {
    loading.value = true;
    try {
      await getCSRFCookie();
      await loginApi(data);
      await getUser();
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };
  const logout = async () => {
    await logoutApi();
    user.value = null;
  };
  const values = {
    user,
    error,
    loading,
    message,
    isLoggedIn,
    getUser,
    login,
    logout,
  };
  return values;
});
