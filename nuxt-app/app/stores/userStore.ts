import {
  userDestroyApi,
  userIndexApi,
  userShowApi,
  userStoreApi,
  userUpdateApi,
  type UserIndexParams,
} from "~/services/users";
import type { User, UserStoreData, UserUpdateData } from "~/types/userTypes";
import type { PaginationMeta } from "~/types/dataWrapper";

export const useUserStore = defineStore("user", () => {
  const user = ref<User | null>(null);
  const users = ref<User[]>([]);
  const loading = ref(false);
  const meta = ref<PaginationMeta>({ current_page: 1, last_page: 1, per_page: 15, total: 0, from: 1, to: 0 });

  const getUsers = async (params: UserIndexParams = {}) => {
    loading.value = true;
    try {
      const response = await userIndexApi(params);
      users.value = response.data.data;
      meta.value = response.data.meta;
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const getUser = async (id: number) => {
    loading.value = true;
    try {
      const response = await userShowApi(id);
      user.value = response.data.data;
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const createUser = async (data: UserStoreData) => {
    loading.value = true;
    try {
      await userStoreApi(data);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const updateUser = async (data: UserUpdateData, id: number) => {
    loading.value = true;
    try {
      await userUpdateApi(data, id);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const deleteUser = async (id: number) => {
    loading.value = true;
    try {
      await userDestroyApi(id);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  return { user, users, loading, meta, getUsers, getUser, createUser, updateUser, deleteUser };
});
