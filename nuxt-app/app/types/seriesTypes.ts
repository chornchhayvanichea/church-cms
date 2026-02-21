export interface Series {
  id: number;
  name: string;
  slug: string;
  description?: string;
  thumbnail?: string;
  startDate?: string;
  endDate?: string;
  createdAt: string;
  updatedAt: string;
}

//Table series {
//  id bigint [pk, increment]
//  name varchar [not null]
//  slug varchar [unique, not null]
//  description text
//  thumbnail varchar
//  start_date date
//  end_date date
//  created_at timestamp
//  updated_at timestamp
//}
