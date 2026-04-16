import {
  eventDestroyApi,
  eventIndexApi,
  eventShowApi,
  eventStoreApi,
  eventUpdateApi,
  publicEventIndexApi,
  type EventIndexParams,
  type PublicEventIndexParams,
} from "~/services/events";
import type { Event, EventStoreData } from "~/types/eventTypes";
import type { PaginationMeta } from "~/types/dataWrapper";

export const useEventStore = defineStore("event", () => {
  const event = ref<Event | null>(null);
  const events = ref<Event[]>([]);
  const loading = ref(false);
  const meta = ref<PaginationMeta>({ current_page: 1, last_page: 1, per_page: 15, total: 0, from: 1, to: 0 });

  const getEvents = async (params: EventIndexParams = {}) => {
    loading.value = true;
    try {
      const response = await eventIndexApi(params);
      events.value = response.data.data;
      meta.value = response.data.meta;
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const getEvent = async (id: number) => {
    loading.value = true;
    try {
      const response = await eventShowApi(id);
      event.value = response.data.data;
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const createEvent = async (data: EventStoreData) => {
    loading.value = true;
    try {
      await eventStoreApi(data);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const updateEvent = async (data: EventStoreData, id: number) => {
    loading.value = true;
    try {
      await eventUpdateApi(data, id);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const deleteEvent = async (id: number) => {
    loading.value = true;
    try {
      await eventDestroyApi(id);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  // --- Public ---
  const publicEvents = ref<Event[]>([]);
  const publicMeta = ref<PaginationMeta>({ current_page: 1, last_page: 1, per_page: 12, total: 0, from: 1, to: 0 });
  const publicLoading = ref(false);

  const getPublicEvents = async (params: PublicEventIndexParams = {}) => {
    publicLoading.value = true;
    try {
      const response = await publicEventIndexApi(params);
      publicEvents.value = response.data.data;
      publicMeta.value = response.data.meta;
    } catch (e) {
      console.error(e);
    } finally {
      publicLoading.value = false;
    }
  };

  return { event, events, loading, meta, getEvents, getEvent, createEvent, updateEvent, deleteEvent, publicEvents, publicMeta, publicLoading, getPublicEvents };
});
