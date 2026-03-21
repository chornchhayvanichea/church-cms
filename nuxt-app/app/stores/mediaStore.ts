import {
  destroyMediaApi,
  indexMediaApi,
  storeMediaApi,
} from "~/services/media";
import type { PaginationMeta } from "~/types/dataWrapper";
import type { Media, UploadData } from "~/types/mediaTypes";

export const useMediaStore = defineStore("media", () => {
  const media = ref<Media[]>([]);
  const loading = ref(false);

  const meta = ref<PaginationMeta>({
    current_page: 1,
    last_page: 1,
    per_page: 30,
    total: 0,
    from: 0,
    to: 0,
  });
  const images = computed(() =>
    media.value.filter((m) => m.mime_type?.startsWith("image")),
  );
  const audios = computed(() =>
    media.value.filter((m) => m.mime_type?.startsWith("audio")),
  );
  const videos = computed(() =>
    media.value.filter((m) => m.mime_type?.startsWith("video")),
  );

  const getMedia = async (page = 1, type?: string) => {
    loading.value = true;
    try {
      const response = await indexMediaApi(page, type);
      media.value = response.data.data;
      meta.value = response.data.meta;
      console.log(media.value);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };
  const removeMedia = async (id: number) => {
    try {
      console.log("deleting id:", id);
      const response = await destroyMediaApi(id);
      console.log(response);
      media.value = media.value.filter((m) => m.id !== id);
    } catch (e) {
      console.error(e);
    }
  };
  const uploadMedia = async (data: UploadData) => {
    loading.value = true;
    try {
      const response = await storeMediaApi(data);
      await getMedia();
      console.log(response);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };
  const values = {
    media,
    meta,
    loading,
    getMedia,
    uploadMedia,
    images,
    audios,
    videos,
    removeMedia,
  };
  return values;
});
