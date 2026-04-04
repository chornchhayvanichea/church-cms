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

  const ImageMedia = ref<Media[]>([]);
  const AudioMedia = ref<Media[]>([]);
  const VideoMedia = ref<Media[]>([]);

  const meta = ref<PaginationMeta>({
    current_page: 1,
    last_page: 1,
    per_page: 30,
    total: 0,
    from: 0,
    to: 0,
  });

  const images = ImageMedia;
  const audios = AudioMedia;
  const videos = VideoMedia;

  //  const images = computed(() =>
  //    media.value.filter((m) => m.mime_type?.startsWith("image")),
  //  );
  //  const audios = computed(() =>
  //    media.value.filter((m) => m.mime_type?.startsWith("audio")),
  //  );
  //  const videos = computed(() =>
  //    media.value.filter((m) => m.mime_type?.startsWith("video")),
  //  );
  //
  const getMedia = async (page = 1, type?: string) => {
    loading.value = true;
    try {
      const response = await indexMediaApi(page, type);
      const data = response.data.data;
      meta.value = response.data.meta;

      if (type === "image") ImageMedia.value = data;
      else if (type === "audio") AudioMedia.value = data;
      else if (type === "video") VideoMedia.value = data;
      else media.value = data;

      console.log("all media:", media.value.length);
      console.log(
        "audios:",
        media.value.filter((m) => m.mime_type?.startsWith("audio")).length,
      );
      console.log(media.value);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };
  const removeMedia = async (id: number, force = false) => {
    try {
      console.log("deleting id:", id);
      const response = await destroyMediaApi(id, force);
      media.value = media.value.filter((m) => m.id !== id);
      console.log(response);
    } catch (error: unknown) {
      const apiError = error as { response?: { data?: { in_use?: boolean } } };
      if (apiError?.response?.data?.in_use) {
        const confirmed = confirm(
          "This media is used in a blog. Delete anyway?",
        );
        if (confirmed) removeMedia(id, true);
      }
    }
  };
  const uploadMedia = async (data: UploadData) => {
    loading.value = true;
    try {
      const response = await storeMediaApi(data);
      await getMedia(1, data.collection);
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
    ImageMedia,
    AudioMedia,
    VideoMedia,
  };
  return values;
});
