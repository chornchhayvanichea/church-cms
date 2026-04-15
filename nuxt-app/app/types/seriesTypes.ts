import type { Sermon } from "./sermonTypes";

export interface Series {
  id: number;
  name: string;
  slug: string;
  description?: string;
  thumbnail?: string;
  start_date?: string;
  end_date?: string;
  sermons: Sermon[];
  created_at: string;
  updated_at: string;
}

export interface SeriesStoreData {
  name: string;
  description?: string;
  thumbnail?: File | string;
  start_date?: string;
  end_date?: string;
}

export type SeriesUpdateData = SeriesStoreData;
