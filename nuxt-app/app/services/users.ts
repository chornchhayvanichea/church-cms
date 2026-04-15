import { api } from "./axios";
import { END_POINTS } from "~/constants/api";
import type { ApiResponse, PaginateResponse } from "~/types/dataWrapper";
import type { User, UserStoreData, UserUpdateData } from "~/types/userTypes";

export interface UserIndexParams {
  page?: number;
  per_page?: number;
  "filter[name]"?: string;
  "filter[email]"?: string;
  "filter[role]"?: string;
}

export const userIndexApi = (params: UserIndexParams = {}) => {
  return api.get<PaginateResponse<User>>(END_POINTS.USER.INDEX, { params });
};

export const userShowApi = (id: number) => {
  return api.get<ApiResponse<User>>(END_POINTS.USER.SHOW(id));
};

export const userStoreApi = (data: UserStoreData) => {
  const formData = new FormData();
  formData.append("name", data.name);
  formData.append("email", data.email);
  formData.append("password", data.password);
  formData.append("role", data.role);
  if (data.avatar instanceof File) formData.append("avatar", data.avatar);
  return api.post<ApiResponse<User>>(END_POINTS.USER.STORE, formData);
};

export const userUpdateApi = (data: UserUpdateData, id: number) => {
  const formData = new FormData();
  if (data.name) formData.append("name", data.name);
  if (data.email) formData.append("email", data.email);
  if (data.password) formData.append("password", data.password);
  if (data.role) formData.append("role", data.role);
  if (data.avatar instanceof File) formData.append("avatar", data.avatar);
  else if (data.avatar === undefined) formData.append("remove_avatar", "1");
  formData.append("_method", "PUT");
  return api.post<ApiResponse<User>>(END_POINTS.USER.UPDATE(id), formData);
};

export const userDestroyApi = (id: number) => {
  return api.delete<{ message: string }>(END_POINTS.USER.DESTROY(id));
};
