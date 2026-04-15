import type { ApiResponse, PaginateResponse } from "~/types/dataWrapper";
import { api } from "./axios";
import type { Sermon, SermonStoreData } from "~/types/sermonTypes";
import { END_POINTS } from "~/constants/api";

export const sermonStoreApi = (data: SermonStoreData) => {
  const formData = new FormData();
  formData.append("title", data.title);
  formData.append("speaker", data.speaker);
  formData.append("sermon_date", data.sermon_date);
  if (data.description) formData.append("description", data.description);
  if (data.notes) formData.append("notes", data.notes);
  if (data.scripture_reference)
    formData.append("scripture_reference", data.scripture_reference);
  appendFileOrUrl(formData, "thumbnail", data.thumbnail);
  appendFileOrUrl(formData, "audio", data.audio);
  appendFileOrUrl(formData, "video", data.video);
  if (data.published_at) formData.append("published_at", data.published_at);
  if (data.status) formData.append("status", data.status);
  return api.post<ApiResponse<Sermon>>(END_POINTS.SERMON.STORE, formData);
};
export const sermonUpdateApi = (data: SermonStoreData, id: number) => {
  const formData = new FormData();
  formData.append("title", data.title);
  formData.append("speaker", data.speaker);
  formData.append("sermon_date", data.sermon_date);
  if (data.description) formData.append("description", data.description);
  if (data.notes) formData.append("notes", data.notes);
  if (data.scripture_reference)
    formData.append("scripture_reference", data.scripture_reference);
  appendFileOrUrl(formData, "thumbnail", data.thumbnail);
  appendFileOrUrl(formData, "audio", data.audio);
  appendFileOrUrl(formData, "video", data.video);
  if (data.published_at)
    formData.append("published_at", new Date(data.published_at).toISOString());
  if (data.status) formData.append("status", data.status);

  formData.append("_method", "PUT");
  return api.post<ApiResponse<Sermon>>(END_POINTS.SERMON.UPDATE(id), formData);
};

export const sermonShowApi = (id: number) => {
  return api.get<ApiResponse<Sermon>>(END_POINTS.SERMON.SHOW(id));
};
export interface SermonIndexParams {
  page?: number;
  'filter[title]'?: string;
  'filter[status]'?: string;
  'filter[speaker]'?: string;
}

export const sermonIndexApi = (params: SermonIndexParams = {}) => {
  return api.get<PaginateResponse<Sermon>>(END_POINTS.SERMON.INDEX, { params });
};

export const sermonDestroyApi = (id: number) => {
  return api.delete<{ message: string }>(END_POINTS.SERMON.DESTROY(id));
};
