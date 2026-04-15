import {
  sermonDestroyApi,
  sermonIndexApi,
  sermonShowApi,
  sermonStoreApi,
  sermonUpdateApi,
} from "~/services/sermons";
import type { Sermon, SermonStoreData } from "~/types/sermonTypes";

export const useSermonStore = defineStore("sermon", () => {
  const sermon = ref<Sermon | null>(null);
  const sermons = ref<Sermon[]>([]);
  const loading = ref(false);

  const getSermons = async () => {
    loading.value = true;
    try {
      const response = await sermonIndexApi();
      sermons.value = response.data.data;
      console.log(response);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const createSermon = async (data: SermonStoreData) => {
    loading.value = true;
    try {
      const response = await sermonStoreApi(data);
      await getSermons();
      console.log(response);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };
  const updateSermon = async (data: SermonStoreData, id: number) => {
    loading.value = true;
    try {
      const response = await sermonUpdateApi(data, id);
      await getSermons();
      console.log("Update success", response.data);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const deleteSermon = async (id: number) => {
    loading.value = true;
    try {
      await sermonDestroyApi(id);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };
  const getSermon = async (id: number) => {
    loading.value = true;
    try {
      const response = await sermonShowApi(id);
      sermon.value = response.data.data;
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };
  const values = {
    sermon,
    sermons,
    loading,
    getSermons,
    createSermon,
    deleteSermon,
    getSermon,
    updateSermon,
  };
  return values;
});
