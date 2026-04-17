import { api } from "./axios";
import { END_POINTS } from "~/constants/api";
import type { Settings } from "~/types/settingTypes";

interface SettingsResponse {
  data: Settings;
  message?: string;
}

export const publicSettingsApi = () =>
  api.get<SettingsResponse>(END_POINTS.SETTING.PUBLIC_INDEX);

export const updateSettingsApi = (settings: Settings) =>
  api.put<SettingsResponse>(END_POINTS.SETTING.UPDATE, { settings });
