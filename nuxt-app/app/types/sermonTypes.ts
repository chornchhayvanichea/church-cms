import type { User } from "./userTypes";

export interface Sermon {
  id: number;
  title: string;
  //  slug: string;
  speaker: string;
  sermon_date: string;
  series_id?: number;
  description?: string;
  notes?: string;
  scripture_reference?: string;
  video?: string;
  audio?: string;
  thumbnail?: string;
  status?: SermonStatus;
  view_count: number;
  created_by: User;
  published_at?: string;
  // created_at: string;
  //updated_at: string;
}

export interface SermonStoreData {
  title: string;
  speaker: string;
  sermon_date: string;
  description?: string;
  notes?: string;
  scripture_reference?: string;
  video?: File;
  audio?: File;
  thumbnail?: File;
  published_at?: string;
  status?: SermonStatus;
}
export enum SermonStatus {
  draft = "draft",
  published = "published",
  archived = "archived",
}
