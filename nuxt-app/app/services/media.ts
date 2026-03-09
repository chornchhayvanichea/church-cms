import type { ApiResponse } from "~/types/dataWrapper";
import type { Media, UploadData } from "~/types/mediaTypes";
import { api } from "./axios";
import { END_POINTS } from "~/constants/api";

export const indexMediaApi = () => {
  return api.get<ApiResponse<Media[]>>(END_POINTS.MEDIA.INDEX);
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
