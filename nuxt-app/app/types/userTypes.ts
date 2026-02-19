enum Role {
  admin = "admin",
  editor = "editor",
}
export interface User {
  name: string;
  email: string;
  password: string;
  role: Role;
  image?: string;
}
