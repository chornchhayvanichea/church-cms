import type { ApiResponse, PaginateResponse } from "~/types/dataWrapper";
import type { Media, UploadData } from "~/types/mediaTypes";
import { api } from "./axios";
import { END_POINTS } from "~/constants/api";

export const indexMediaApi = (page = 1) => {
  return api.get<PaginateResponse<Media[]>>(END_POINTS.MEDIA.INDEX, {
    params: { page },
  });
};

export const destroyMediaApi = (id: number | string) => {
  return api.delete<{ message: string }>(END_POINTS.MEDIA.DESTROY(id));
};

export const storeMediaApi = (data: UploadData) => {
  const formData = new FormData();
  formData.append("file", data.file);
  formData.append("collection", data.collection);

  return api.post<ApiResponse<Media>>(END_POINTS.MEDIA.STORE, formData, {
    headers: { "Content-Type": "multipart/form-data" },
  });
};
