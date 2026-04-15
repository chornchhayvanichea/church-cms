import {
  seriesDestroyApi,
  seriesIndexApi,
  seriesShowApi,
  seriesStoreApi,
  seriesUpdateApi,
  type SeriesIndexParams,
} from "~/services/series";
import type { Series, SeriesStoreData } from "~/types/seriesTypes";
import type { PaginationMeta } from "~/types/dataWrapper";

export const useSeriesStore = defineStore("series", () => {
  const series = ref<Series | null>(null);
  const seriesList = ref<Series[]>([]);
  const loading = ref(false);
  const meta = ref<PaginationMeta>({ current_page: 1, last_page: 1, per_page: 15, total: 0, from: 1, to: 0 });

  const getSeriesList = async (params: SeriesIndexParams = {}) => {
    loading.value = true;
    try {
      const response = await seriesIndexApi(params);
      seriesList.value = response.data.data;
      meta.value = response.data.meta;
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const getSeries = async (id: number) => {
    loading.value = true;
    try {
      const response = await seriesShowApi(id);
      series.value = response.data.data;
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const createSeries = async (data: SeriesStoreData) => {
    loading.value = true;
    try {
      await seriesStoreApi(data);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const updateSeries = async (data: SeriesStoreData, id: number) => {
    loading.value = true;
    try {
      await seriesUpdateApi(data, id);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const deleteSeries = async (id: number) => {
    loading.value = true;
    try {
      await seriesDestroyApi(id);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  return { series, seriesList, loading, meta, getSeriesList, getSeries, createSeries, updateSeries, deleteSeries };
});
