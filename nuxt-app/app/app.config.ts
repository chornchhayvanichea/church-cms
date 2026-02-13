export default defineAppConfig({
  ui: {
    footerColumns: {
      slots: {
        root: "xl:grid xl:grid-cols-3 xl:gap-8",
        left: "mb-10 xl:mb-0 max-w-md [&_p]:text-gray-500",
      },
    },
  },
});
