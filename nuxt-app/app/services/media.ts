import type { ApiResponse, PaginateResponse } from "~/types/dataWrapper";

import type { Media, UploadData } from "~/types/mediaTypes";
import { api } from "./axios";
import { END_POINTS } from "~/constants/api";

/*
 * type is referred to mime_type of media
 */
export const indexMediaApi = (page = 1, type?: string) => {
  return api.get<PaginateResponse<Media[]>>(END_POINTS.MEDIA.INDEX, {
    params: {
      page,

      ...(type && { "filter[mime_type]": type }),
    },
  });
};

export const destroyMediaApi = (id: number | string, force = false) => {
  return api.delete<{ message: string }>(END_POINTS.MEDIA.DESTROY(id), {
    params: { force },
  });
};

export const storeMediaApi = (data: UploadData) => {
  const formData = new FormData();
  formData.append("file", data.file);
  formData.append("collection", data.collection);
  return api.post<ApiResponse<Media>>(END_POINTS.MEDIA.STORE, formData);
};
