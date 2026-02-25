export const BASE = "http://localhost:8000";
const API = "/api";
export const END_POINTS = {
  USER: {
    GET: `${API}/user`,
  },
  BLOG: {
    STORE: `${API}/blogs`,
    INDEX: `${API}/blogs`,
    SHOW: (id: number | string) => `${API}/blogs/${id}`,
    UPDATE: (id: number | string) => `${API}/blogs/${id}`,
    DESTROY: (id: number | string) => `${API}/blogs/${id}`,
  },
  AUTH: {
    LOGIN: `${API}/login`,
    LOGOUT: `${API}/logout`,
  },
  SANCTUM: {
    CSRF: "/sanctum/csrf-cookie",
  },
};
