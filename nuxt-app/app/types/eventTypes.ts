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
  createdBt: string;
  updatedBt: string;
}
enum Status {
  upcoming = "upcoming",
  past = "past",
  cancelled = "cancelled",
}

//Table events {
//  id bigint [pk, increment]
//  title varchar [not null]
//  slug varchar [unique, not null]
//  description longtext
//  event_date date [not null]
//  event_time time
//  end_date date
//  end_time time
//  location varchar
//  image varchar
//  registration_link varchar
//  status varchar [default: 'upcoming', note: 'upcoming, past, cancelled']
//  created_by bigint [not null]
//  created_at timestamp
//  updated_at timestamp
//}
