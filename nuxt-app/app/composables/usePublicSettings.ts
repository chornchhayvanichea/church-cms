export const usePublicSettings = async () => {
  const settingStore = useSettingStore();
  const { settings } = storeToRefs(settingStore);

  await useAsyncData(
    "public-settings",
    () => settingStore.getPublicSettings(),
    { getCachedData: () => undefined },
  );

  return { settings };
};
