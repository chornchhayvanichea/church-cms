import type { User } from "./userTypes";

export interface Blog {
  id: number;
  title: string;
  slug: string;
  content: HTMLElement;
  excerpt?: string;
  thumbnail?: string;
  status: Status;
  author_id: number;
  author: User;
  published_at: string;
  createdAt: string;
  updatedAt: string;
}
export interface EditorImage {
  url: string;
  id: number;
}
enum Status {
  draft = "draft",
  published = "published",
  archived = "archived",
}
