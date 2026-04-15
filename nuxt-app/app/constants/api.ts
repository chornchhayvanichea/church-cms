export const BASE = "http://localhost:8000";
const API = "/api";
export const END_POINTS = {
  USER: {
    GET: `${API}/user`,
  },
  MEDIA: {
    INDEX: `${API}/media`,
    STORE: `${API}/media`,
    DESTROY: (id: number | string) => `${API}/media/${id}`,
  },
  BLOG: {
    STORE: `${API}/blogs`,
    INDEX: `${API}/blogs`,
    SHOW: (id: number | string) => `${API}/blogs/${id}`,
    UPDATE: (id: number | string) => `${API}/blogs/${id}`,
    DESTROY: (id: number | string) => `${API}/blogs/${id}`,
    EDITOR_UPLOAD_IMAGE: `${API}/blogs/upload-editor-image`,
  },
  EVENT: {
    INDEX: `${API}/events`,
    STORE: `${API}/events`,
    SHOW: (id: number | string) => `${API}/events/${id}`,
    UPDATE: (id: number | string) => `${API}/events/${id}`,
    DESTROY: (id: number | string) => `${API}/events/${id}`,
  },
  SERMON: {
    STORE: `${API}/sermons`,
    INDEX: `${API}/sermons`,
    SHOW: (id: number | string) => `${API}/sermons/${id}`,
    UPDATE: (id: number | string) => `${API}/sermons/${id}`,
    DESTROY: (id: number | string) => `${API}/sermons/${id}`,
  },
  AUTH: {
    LOGIN: `${API}/login`,
    LOGOUT: `${API}/logout`,
    SIGNUP: `${API}/signup`,
  },
  SANCTUM: {
    CSRF: "/sanctum/csrf-cookie",
  },
};
