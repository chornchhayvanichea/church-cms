import type { User } from "./userTypes";

export interface SermonSeries {
  id: number;
  name: string;
  slug: string;
  description?: string;
  thumbnail?: string;
}

export interface Sermon {
  id: number;
  title: string;
  slug: string;
  speaker: string;
  sermon_date: string;
  series_id?: number;
  series?: SermonSeries;
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
  video?: File | string;
  audio?: File | string;
  thumbnail?: File | string;
  published_at?: string;
  status?: SermonStatus;
  series_id?: number | null;
}
export type SermonUpdateData = SermonStoreData;
export enum SermonStatus {
  draft = "draft",
  published = "published",
  archived = "archived",
}
