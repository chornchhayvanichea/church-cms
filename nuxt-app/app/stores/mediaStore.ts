import { destroyMediaApi, indexMediaApi } from "~/services/media";
import type { Media } from "~/types/mediaTypes";

export const useMediaStore = defineStore("media", () => {
  const media = ref<Media[]>([]);
  const loading = ref(false);

  const images = computed(() =>
    media.value.filter((m) => m.mime_type?.startsWith("image")),
  );
  const audios = computed(() =>
    media.value.filter((m) => m.mime_type?.startsWith("audio")),
  );
  const videos = computed(() =>
    media.value.filter((m) => m.mime_type?.startsWith("video")),
  );

  const getMedia = async () => {
    loading.value = true;
    try {
      const response = await indexMediaApi();
      media.value = response.data.data;
      console.log(media.value);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };
  const removeMedia = async (id: number) => {
    try {
      await destroyMediaApi(id);
      media.value = media.value.filter((m) => m.id !== id);
    } catch (e) {
      console.error(e);
    }
  };
  const values = {
    media,
    loading,
    getMedia,
    images,
    audios,
    videos,
    removeMedia,
  };
  return values;
});
