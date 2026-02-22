enum Role {
  admin = "admin",
  editor = "editor",
}
export interface User {
  id: number;
  name: string;
  email: string;
  password: string;
  role: Role;
  image?: string;
  created_at: string;
  updated_at: string;
}
