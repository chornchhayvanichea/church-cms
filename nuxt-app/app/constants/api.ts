export const BASE = "http://localhost:8000";
const API = "/api";
export const END_POINTS = {
  USER: {
    GET: `${API}/user`,
    INDEX: `${API}/users`,
    STORE: `${API}/users`,
    SHOW: (id: number | string) => `${API}/users/${id}`,
    UPDATE: (id: number | string) => `${API}/users/${id}`,
    DESTROY: (id: number | string) => `${API}/users/${id}`,
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
    PUBLIC_INDEX: `${API}/public/blogs`,
    PUBLIC_SHOW: (slug: string) => `${API}/public/blogs/${slug}`,
  },
  SERIES: {
    INDEX: `${API}/series`,
    STORE: `${API}/series`,
    SHOW: (id: number | string) => `${API}/series/${id}`,
    UPDATE: (id: number | string) => `${API}/series/${id}`,
    DESTROY: (id: number | string) => `${API}/series/${id}`,
    SYNC_SERMONS: (id: number | string) => `${API}/series/${id}/sermons`,
  },
  EVENT: {
    INDEX: `${API}/events`,
    STORE: `${API}/events`,
    SHOW: (id: number | string) => `${API}/events/${id}`,
    UPDATE: (id: number | string) => `${API}/events/${id}`,
    DESTROY: (id: number | string) => `${API}/events/${id}`,
    PUBLIC_INDEX: `${API}/public/events`,
  },
  SERMON: {
    STORE: `${API}/sermons`,
    INDEX: `${API}/sermons`,
    SHOW: (id: number | string) => `${API}/sermons/${id}`,
    UPDATE: (id: number | string) => `${API}/sermons/${id}`,
    DESTROY: (id: number | string) => `${API}/sermons/${id}`,
    PUBLIC_INDEX: `${API}/public/sermons`,
    PUBLIC_SHOW: (slug: string) => `${API}/public/sermons/${slug}`,
  },
  DASHBOARD: {
    OVERVIEW: `${API}/overview`,
  },
  SETTING: {
    PUBLIC_INDEX: `${API}/public/settings`,
    UPDATE: `${API}/settings`,
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
