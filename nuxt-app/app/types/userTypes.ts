export enum UserRole {
  admin = "admin",
  editor = "editor",
}

export interface User {
  id: number;
  name: string;
  email: string;
  avatar?: string;
  role: UserRole;
  created_at: string;
  updated_at: string;
}

export interface UserStoreData {
  name: string;
  email: string;
  password: string;
  role: UserRole;
  avatar?: File | string;
}

export interface UserUpdateData {
  name?: string;
  email?: string;
  password?: string;
  role?: UserRole;
  avatar?: File | string;
}
