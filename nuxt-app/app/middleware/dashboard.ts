const ADMIN_ONLY_PATHS = ["/dashboard/users", "/dashboard/settings/site"];

export default defineNuxtRouteMiddleware(async (to) => {
  if (import.meta.server) return;

  const store = useAuthStore();
  if (!store.user) {
    await store.getUser();
  }
  if (to.path.startsWith("/dashboard")) {
    to.meta.layout = "dashboard";
    if (!store.user) {
      return navigateTo("/auth/login");
    }
    if (ADMIN_ONLY_PATHS.some((p) => to.path.startsWith(p)) && !store.isAdmin) {
      return navigateTo("/dashboard");
    }
  }
});
