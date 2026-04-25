import { api } from "./axios";
import { END_POINTS } from "~/constants/api";
import type { ApiResponse, PaginateResponse } from "~/types/dataWrapper";
import type { Event, EventStoreData } from "~/types/eventTypes";

export interface EventIndexParams {
  page?: number;
  "filter[title]"?: string;
  "filter[status]"?: string;
}

export const eventIndexApi = (params: EventIndexParams = {}) => {
  return api.get<PaginateResponse<Event>>(END_POINTS.EVENT.INDEX, { params });
};

export const eventShowApi = (id: number) => {
  return api.get<ApiResponse<Event>>(END_POINTS.EVENT.SHOW(id));
};

export const eventStoreApi = (data: EventStoreData) => {
  const formData = new FormData();
  formData.append("title", data.title);
  formData.append("event_date", data.event_date);
  if (data.description) formData.append("description", data.description);
  if (data.event_time) formData.append("event_time", data.event_time);
  if (data.end_date) formData.append("end_date", data.end_date);
  if (data.end_time) formData.append("end_time", data.end_time);
  if (data.location) formData.append("location", data.location);
  if (data.registration_link)
    formData.append("registration_link", data.registration_link);
  if (data.status) formData.append("status", data.status);
  appendFileOrUrl(formData, "image", data.image);
  return api.post<ApiResponse<Event>>(END_POINTS.EVENT.STORE, formData);
};

export const eventUpdateApi = (data: EventStoreData, id: number) => {
  const formData = new FormData();
  formData.append("title", data.title);
  formData.append("event_date", data.event_date);
  if (data.description) formData.append("description", data.description);
  if (data.event_time) formData.append("event_time", data.event_time);
  if (data.end_date) formData.append("end_date", data.end_date);
  if (data.end_time) formData.append("end_time", data.end_time);
  if (data.location) formData.append("location", data.location);
  if (data.registration_link)
    formData.append("registration_link", data.registration_link);
  if (data.status) formData.append("status", data.status);
  appendFileOrUrl(formData, "image", data.image);
  formData.append("_method", "PUT");
  return api.post<ApiResponse<Event>>(END_POINTS.EVENT.UPDATE(id), formData);
};

export const eventDestroyApi = (id: number) => {
  return api.delete<{ message: string }>(END_POINTS.EVENT.DESTROY(id));
};

export interface PublicEventIndexParams {
  page?: number;
  "filter[title]"?: string;
}

export const publicEventIndexApi = (params: PublicEventIndexParams = {}) => {
  return api.get<PaginateResponse<Event>>(END_POINTS.EVENT.PUBLIC_INDEX, {
    params,
  });
};
