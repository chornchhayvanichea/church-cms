import type { ApiResponse, PaginateResponse } from "~/types/dataWrapper";
import { api } from "./axios";
import type { Blog, BlogStoreData, EditorImage } from "~/types/blogTypes";
import { END_POINTS } from "~/constants/api";

export interface BlogIndexParams {
  page?: number;
  "filter[title]"?: string;
  "filter[status]"?: string;
  "filter[author_id]"?: number;
}

export const blogIndexApi = (params: BlogIndexParams = {}) => {
  return api.get<PaginateResponse<Blog>>(END_POINTS.BLOG.INDEX, { params });
};

export const blogShowApi = (id: number) => {
  return api.get<ApiResponse<Blog>>(END_POINTS.BLOG.SHOW(id));
};

export const blogStoreApi = async (data: BlogStoreData) => {
  const formData = new FormData();
  formData.append("title", data.title);
  formData.append("content", data.content);
  if (data.excerpt) formData.append("excerpt", data.excerpt);
  if (data.status) formData.append("status", data.status);
  appendFileOrUrl(formData, "thumbnail", data.thumbnail);
  if (data.published_at)
    formData.append("published_at", new Date(data.published_at).toISOString());
  return api.post<ApiResponse<Blog>>(END_POINTS.BLOG.STORE, formData);
};

export const blogUpdateApi = async (data: BlogStoreData, id: number) => {
  const formData = new FormData();
  formData.append("title", data.title);
  formData.append("content", data.content);
  if (data.excerpt) formData.append("excerpt", data.excerpt);
  if (data.status) formData.append("status", data.status);
  appendFileOrUrl(formData, "thumbnail", data.thumbnail);
  if (data.published_at)
    formData.append("published_at", new Date(data.published_at).toISOString());

  formData.append("_method", "PUT");
  return api.post<ApiResponse<Blog>>(END_POINTS.BLOG.UPDATE(id), formData);
};

export const blogDestroyApi = (id: number) => {
  return api.delete<{ message: string }>(END_POINTS.BLOG.DESTROY(id));
};

export const publicBlogIndexApi = (
  params: { page?: number; "filter[title]"?: string } = {},
) => {
  return api.get<PaginateResponse<Blog>>(END_POINTS.BLOG.PUBLIC_INDEX, {
    params,
  });
};

export const publicBlogShowApi = (slug: string) => {
  return api.get<ApiResponse<Blog>>(END_POINTS.BLOG.PUBLIC_SHOW(slug));
};

export const editorUploadImage = async (image: File) => {
  const formData = new FormData();
  formData.append("image", image);
  return api.post<EditorImage>(END_POINTS.BLOG.EDITOR_UPLOAD_IMAGE, formData);
};
