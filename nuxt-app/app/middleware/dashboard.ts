export default defineNuxtRouteMiddleware(async (to) => {
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
