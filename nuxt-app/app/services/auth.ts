import { END_POINTS } from "~/constants/api";
import { api } from "./axios";
import type { ApiResponse } from "~/types/dataWrapper";
import type { User } from "~/types/userTypes";
import type { LoginData, SignupData } from "~/types/authTypes";

export const getCSRFCookie = () => {
  return api.get(END_POINTS.SANCTUM.CSRF);
};
export const getUserApi = () => {
  return api.get<ApiResponse<User>>(END_POINTS.USER.GET);
};
export const signupApi = async (data: SignupData) => {
  return api.post<ApiResponse<User>>(END_POINTS.AUTH.SIGNUP, data);
};
export const loginApi = async (data: LoginData) => {
  await getCSRFCookie();
  return api.post<ApiResponse<User>>(END_POINTS.AUTH.LOGIN, data);
};

export const logoutApi = () => {
  return api.post<{ message: string }>(END_POINTS.AUTH.LOGOUT);
};
