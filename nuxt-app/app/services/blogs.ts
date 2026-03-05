import type { ApiResponse } from "~/types/dataWrapper";
import { api } from "./axios";
import type { Blog, EditorImage } from "~/types/blogTypes";
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

export const editorUploadImage = async (image: File) => {
  const formData = new FormData();
  formData.append("image", image);
  return await api.post<EditorImage>(
    END_POINTS.BLOG.EDITOR_UPLOAD_IMAGE,
    formData,
    {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    },
  );
};
