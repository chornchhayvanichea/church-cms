export const BASE = "http://localhost:8000";
const API = "/api";
export const END_POINTS = {
  USER: `${API}/user`,
  AUTH: {
    LOGIN: `${API}/login`,
    LOGOUT: `${API}/logout`,
  },
  SANCTUM: {
    CSRF: "/sanctum/csrf-cookie",
  },
};
