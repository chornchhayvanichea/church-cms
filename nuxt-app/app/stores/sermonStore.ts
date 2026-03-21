import { SermonIndexApi, SermonStoreApi } from "~/services/sermons";
import type { Sermon, SermonStoreData } from "~/types/sermonTypes";

export const useSermonStore = defineStore("sermon", () => {
  const sermon = ref<Sermon | null>(null);
  const sermons = ref<Sermon[]>([]);
  const loading = ref(false);

  const getSermons = async () => {
    loading.value = true;
    try {
      const response = await SermonIndexApi();
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
      const response = await SermonStoreApi(data);
      await getSermons();
      //debug
      console.log(response);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };
  const values = { sermon, sermons, loading, getSermons, createSermon };
  return values;
});
