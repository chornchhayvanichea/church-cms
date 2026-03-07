export const DASHBOARD_ROUTES = {
  ROOT: "/dashboard",

  AUTH_LOGIN: "/auth/login",
  BLOGS: "/dashboard/blogs",
  BLOGS_CREATE: "/dashboard/blogs/create",
  BLOGS_EDIT: (id: string | number) => `/dashboard/blogs/${id}/edit`,

  EVENTS: "/dashboard/events",
  EVENTS_CREATE: "/dashboard/events/create",
  EVENTS_EDIT: (id: string | number) => `/dashboard/events/${id}/edit`,

  MEDIA: "/dashboard/media",

  SERIES: "/dashboard/series",
  SERIES_CREATE: "/dashboard/series/create",
  SERIES_EDIT: (id: string | number) => `/dashboard/series/${id}/edit`,

  SERMONS: "/dashboard/sermons",
  SERMONS_CREATE: "/dashboard/sermons/create",
  SERMONS_EDIT: (id: string | number) => `/dashboard/sermons/${id}/edit`,

  SETTINGS: {
    PROFILE: "/dashboard/settings/profile",
  },

  USERS: "/dashboard/users",
};
