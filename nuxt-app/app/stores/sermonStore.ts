import {
  sermonDestroyApi,
  sermonIndexApi,
  sermonShowApi,
  sermonStoreApi,
  sermonUpdateApi,
  publicSermonIndexApi,
  publicSermonShowApi,
  type SermonIndexParams,
  type PublicSermonIndexParams,
} from "~/services/sermons";
import type { Sermon, SermonStoreData } from "~/types/sermonTypes";
import type { PaginationMeta } from "~/types/dataWrapper";

export const useSermonStore = defineStore("sermon", () => {
  const sermon = ref<Sermon | null>(null);
  const sermons = ref<Sermon[]>([]);
  const loading = ref(false);
  const meta = ref<PaginationMeta>({ current_page: 1, last_page: 1, per_page: 15, total: 0, from: 1, to: 0 });

  const getSermons = async (params: SermonIndexParams = {}) => {
    loading.value = true;
    try {
      const response = await sermonIndexApi(params);
      sermons.value = response.data.data;
      meta.value = response.data.meta;
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
  // --- Public ---
  const publicSermon = ref<Sermon | null>(null);
  const publicSermons = ref<Sermon[]>([]);
  const publicMeta = ref<PaginationMeta>({ current_page: 1, last_page: 1, per_page: 12, total: 0, from: 1, to: 0 });
  const publicLoading = ref(false);

  const getPublicSermons = async (params: PublicSermonIndexParams = {}) => {
    publicLoading.value = true;
    try {
      const response = await publicSermonIndexApi(params);
      publicSermons.value = response.data.data;
      publicMeta.value = response.data.meta;
    } catch (e) {
      console.error(e);
    } finally {
      publicLoading.value = false;
    }
  };

  const getPublicSermon = async (slug: string) => {
    publicLoading.value = true;
    publicSermon.value = null;
    try {
      const response = await publicSermonShowApi(slug);
      publicSermon.value = response.data.data;
    } catch (e) {
      console.error(e);
      throw e;
    } finally {
      publicLoading.value = false;
    }
  };

  const values = {
    sermon,
    sermons,
    loading,
    meta,
    getSermons,
    createSermon,
    deleteSermon,
    getSermon,
    updateSermon,
    publicSermon,
    publicSermons,
    publicMeta,
    publicLoading,
    getPublicSermons,
    getPublicSermon,
  };
  return values;
});
