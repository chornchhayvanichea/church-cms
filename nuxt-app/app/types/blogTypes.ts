export interface Blogs {
  id: number;
  title: string;
  slug: string;
  content: HTMLElement;
  excerpt?: string;
  thumbnail?: string;
  status: Status;
  authorId: number;
  publishedAt: string;
  createdAt: string;
  updatedAt: string;
}
enum Status {
  draft = "draft",
  published = "published",
  archived = "archived",
}
