import type { User } from "./userTypes";

export interface Sermon {
  id: number;
  title: string;
  slug: string;
  speaker: string;
  sermon_date: string;
  series_id?: number;
  description?: string;
  notes?: string;
  scripture_reference?: string;
  video_url?: string;
  audio_url?: string;
  pdf_url?: string;
  thumbnail?: string;
  status: Status;
  view_count: number;
  created_by: User;
  published_at?: string;
  created_at: string;
  updated_at: string;
}
enum Status {
  draft = "draft",
  published = "published",
  archived = "archived",
}
