import { api } from "./axios";
import { END_POINTS } from "~/constants/api";

export interface PublicSearchResults {
  sermons: Array<{ title: string; slug: string; subtitle: string }>;
  blogs: Array<{ title: string; slug: string; subtitle: string }>;
  events: Array<{ title: string; subtitle: string; event_date: string }>;
}

export const publicSearchApi = (q: string) =>
  api.get<PublicSearchResults>(END_POINTS.SEARCH.PUBLIC, { params: { q } });
