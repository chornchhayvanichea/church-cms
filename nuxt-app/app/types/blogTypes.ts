import type { User } from "./userTypes";

export interface Blog {
  id: number;
  title: string;
  slug: string;
  content: string;
  excerpt?: string;
  thumbnail?: string;
  status: BlogStatus;
  author_id: number | string;
  author: User;
  published_at: string;
  createdAt: string;
  updatedAt: string;
}
export interface BlogStoreData {
  title: string;
  content: string;
  excerpt?: string;
  thumbnail?: File | string | undefined;
  published_at?: string;
  status?: BlogStatus;
}
export interface EditorImage {
  url: string;
  id: number | string;
}
export enum BlogStatus {
  draft = "draft",
  published = "published",
  archived = "archived",
}

export interface ApiError {
  data?: {
    in_use?: boolean;
    message?: string;
  };
}
