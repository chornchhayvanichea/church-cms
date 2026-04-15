import { api } from "./axios";
import { END_POINTS } from "~/constants/api";
import type { ApiResponse, PaginateResponse } from "~/types/dataWrapper";
import type { Series, SeriesStoreData } from "~/types/seriesTypes";

export interface SeriesIndexParams {
  page?: number;
  per_page?: number;
  "filter[name]"?: string;
}

export const seriesIndexApi = (params: SeriesIndexParams = {}) => {
  return api.get<PaginateResponse<Series>>(END_POINTS.SERIES.INDEX, { params });
};

export const seriesShowApi = (id: number) => {
  return api.get<ApiResponse<Series>>(END_POINTS.SERIES.SHOW(id));
};

export const seriesStoreApi = (data: SeriesStoreData) => {
  const formData = new FormData();
  formData.append("name", data.name);
  if (data.description) formData.append("description", data.description);
  if (data.start_date) formData.append("start_date", data.start_date);
  if (data.end_date) formData.append("end_date", data.end_date);
  appendFileOrUrl(formData, "thumbnail", data.thumbnail);
  return api.post<ApiResponse<Series>>(END_POINTS.SERIES.STORE, formData);
};

export const seriesUpdateApi = (data: SeriesStoreData, id: number) => {
  const formData = new FormData();
  formData.append("name", data.name);
  if (data.description) formData.append("description", data.description);
  if (data.start_date) formData.append("start_date", data.start_date);
  if (data.end_date) formData.append("end_date", data.end_date);
  appendFileOrUrl(formData, "thumbnail", data.thumbnail);
  formData.append("_method", "PUT");
  return api.post<ApiResponse<Series>>(END_POINTS.SERIES.UPDATE(id), formData);
};

export const seriesDestroyApi = (id: number) => {
  return api.delete<{ message: string }>(END_POINTS.SERIES.DESTROY(id));
};

export const seriesSyncSermonsApi = (id: number, sermon_ids: number[]) => {
  return api.put<ApiResponse<Series>>(END_POINTS.SERIES.SYNC_SERMONS(id), { sermon_ids });
};
