import type { User } from "./userTypes";

export interface Event {
  id: number;
  title: string;
  slug: string;
  description?: string;
  eventDate: string;
  eventTime?: string;
  endDate?: string;
  endTime?: string;
  location?: string;
  image?: string;
  registrationLink?: string;
  status: Status;
  createdBy: User;
  created_at: string;
  updated_at: string;
}
export enum Status {
  upcoming = "upcoming",
  past = "past",
  cancelled = "cancelled",
}
