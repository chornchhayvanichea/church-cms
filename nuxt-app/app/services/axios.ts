import axios from "axios";
import { BASE } from "~/constants/api";

export const api = axios.create({
  baseURL: BASE,
  withCredentials: true,
  withXSRFToken: true,
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});
