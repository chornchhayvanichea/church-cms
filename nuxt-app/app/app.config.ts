export default defineAppConfig({
  ui: {
    pageHero: {
      slots: {
        title:
          "text-5xl sm:text-7xl text-pretty tracking-tight font-bold text-highlighted text-white",
        description: "text-lg sm:text-xl/8 text-muted text-gray-300",
      },
    },
    input: {
      variants: {
        size: {
          big: {
            base: "px-6 py-2 w-full sm:w-sm text-base gap-2",
            leading: "ps-3",
            trailing: "pe-3",
            leadingIcon: "size-6",
            leadingAvatarSize: "xs",
            trailingIcon: "size-6",
          },
        },
      },
    },
    footerColumns: {
      slots: {
        root: "xl:grid xl:grid-cols-3 xl:gap-8",
        left: "mb-10 xl:mb-0 max-w-md [&_p]:text-gray-500",
      },
    },
  },
});
