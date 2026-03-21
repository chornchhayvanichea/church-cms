import type { ApiResponse } from "~/types/dataWrapper";
import { api } from "./axios";
import type { Sermon, SermonStoreData } from "~/types/sermonTypes";
import { END_POINTS } from "~/constants/api";

export const SermonStoreApi = (data: SermonStoreData) => {
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

export const SermonIndexApi = () => {
  return api.get<ApiResponse<Sermon[]>>(END_POINTS.SERMON.INDEX);
};
