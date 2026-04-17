import { publicSettingsApi, updateSettingsApi } from "~/services/settings";
import type { Settings } from "~/types/settingTypes";

export const useSettingStore = defineStore("setting", () => {
  const settings = ref<Settings>({});
  const loading = ref(false);
  const saving = ref(false);
  const error = ref<string | null>(null);

  const getPublicSettings = async () => {
    loading.value = true;
    try {
      const res = await publicSettingsApi();
      settings.value = res.data.data;
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const saveSettings = async (data: Settings) => {
    saving.value = true;
    error.value = null;
    try {
      const res = await updateSettingsApi(data);
      settings.value = res.data.data;
      return true;
    } catch (e) {
      error.value = "Failed to save settings.";
      console.error(e);
      return false;
    } finally {
      saving.value = false;
    }
  };

  return { settings, loading, saving, error, getPublicSettings, saveSettings };
});
