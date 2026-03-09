enum Role {
  admin = "admin",
  editor = "editor",
}
export interface User {
  id: number | string;
  name: string;
  email: string;
  password: string;
  role: Role;
  image?: File;
  created_at: string;
  updated_at: string;
}
