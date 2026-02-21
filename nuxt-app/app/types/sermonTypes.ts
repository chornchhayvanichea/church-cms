import type { User } from "./userTypes";

export interface Sermon {
  id: number;
  title: string;
  slug: string;
  speaker: string;
  sermonDate: string;
  seriesId?: number;
  description?: string;
  notes?: string;
  scriptureReference?: string;
  videoUrl?: string;
  audioUrl?: string;
  pdfUrl?: string;
  thumbnail?: string;
  status: Status;
  viewCount: number;
  createdBy: User;
  publishedAt?: string;
  createdAt: string;
  updatedAt: string;
}
enum Status {
  draft = "draft",
  published = "published",
  archived = "archived",
}
