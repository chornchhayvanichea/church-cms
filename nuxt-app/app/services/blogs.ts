import type { ApiResponse } from "~/types/dataWrapper";
import { api } from "./axios";
import type { Blog } from "~/types/blogTypes";
import { END_POINTS } from "~/constants/api";

export const storeBlogApi = (data: Partial<Blog>) => {
  return api.post<ApiResponse<Blog>>(END_POINTS.BLOG.STORE, data);
};

export const indexBlogApi = () => {
  return api.get<ApiResponse<Blog>>(END_POINTS.BLOG.INDEX);
};

export const showBlogApi = (id: number) => {
  return api.get<ApiResponse<Blog>>(END_POINTS.BLOG.SHOW(id));
};

export const updaetBlogApi = (id: number, data: Partial<Blog>) => {};
