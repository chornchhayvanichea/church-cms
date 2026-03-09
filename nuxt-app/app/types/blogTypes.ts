import type { User } from "./userTypes";

export interface Blog {
  id: number;
  title: string;
  slug: string;
  content: HTMLElement;
  excerpt?: string;
  thumbnail?: File;
  status: Status;
  author_id: number | string;
  author: User | string;
  published_at: string;
  createdAt: string;
  updatedAt: string;
}

export interface BlogStoreData {
  title: string;
  content: string;
  excerpt?: string;
  thumbnail?: File;
  published_at?: string;
}
export interface EditorImage {
  url: string;
  id: number | string;
}
enum Status {
  draft = "draft",
  published = "published",
  archived = "archived",
}
