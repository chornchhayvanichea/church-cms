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
  }
});
