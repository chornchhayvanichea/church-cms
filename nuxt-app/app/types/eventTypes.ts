import type { User } from "./userTypes";

export interface Event {
  id: number;
  title: string;
  slug: string;
  description?: string;
  event_date: string;
  event_time?: string;
  end_date?: string;
  end_time?: string;
  location?: string;
  image?: string;
  registration_link?: string;
  status: EventStatus;
  created_by: User;
  created_at: string;
  updated_at: string;
}

export interface EventStoreData {
  title: string;
  description?: string;
  event_date: string;
  event_time?: string;
  end_date?: string;
  end_time?: string;
  location?: string;
  image?: File | string;
  registration_link?: string;
  status?: EventStatus;
}

export type EventUpdateData = EventStoreData;

export enum EventStatus {
  upcoming = "upcoming",
  past = "past",
  cancelled = "cancelled",
}
