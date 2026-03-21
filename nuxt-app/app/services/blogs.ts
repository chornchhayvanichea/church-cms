import type { ApiResponse } from "~/types/dataWrapper";
import { api } from "./axios";
import type { Blog, BlogStoreData, EditorImage } from "~/types/blogTypes";
import { END_POINTS } from "~/constants/api";
export const storeBlogApi = async (data: BlogStoreData) => {
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

export const indexBlogApi = () => {
  return api.get<ApiResponse<Blog[]>>(END_POINTS.BLOG.INDEX);
};

export const showBlogApi = (id: number) => {
  return api.get<ApiResponse<Blog>>(END_POINTS.BLOG.SHOW(id));
};

export const editorUploadImage = async (image: File) => {
  const formData = new FormData();
  formData.append("image", image);
  return api.post<EditorImage>(END_POINTS.BLOG.EDITOR_UPLOAD_IMAGE, formData);
};
