import {
  blogDestroyApi,
  blogIndexApi,
  blogShowApi,
  blogStoreApi,
  blogUpdateApi,
  publicBlogIndexApi,
  publicBlogShowApi,
  type BlogIndexParams,
} from "~/services/blogs";
import type { Blog, BlogStoreData } from "~/types/blogTypes";
import type { PaginationMeta } from "~/types/dataWrapper";

export const useBlogStore = defineStore("blog", () => {
  const blog = ref<Blog | null>(null);
  const blogs = ref<Blog[]>([]);
  const loading = ref(false);
  const meta = ref<PaginationMeta>({
    current_page: 1,
    last_page: 1,
    per_page: 15,
    total: 0,
    from: 1,
    to: 0,
  });

  const createBlog = async (data: BlogStoreData) => {
    loading.value = true;
    try {
      await blogStoreApi(data);
      await getBlogs();
    } catch (e) {
      console.error(e);
      throw e;
    } finally {
      loading.value = false;
    }
  };

  const updateBlog = async (data: BlogStoreData, id: number) => {
    loading.value = true;
    try {
      await blogUpdateApi(data, id);
    } catch (e) {
      console.error(e);
      throw e;
    } finally {
      loading.value = false;
    }
  };

  const getBlog = async (id: number) => {
    loading.value = true;
    try {
      const response = await blogShowApi(id);
      blog.value = response.data.data;
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const getBlogs = async (params: BlogIndexParams = {}) => {
    loading.value = true;
    try {
      const response = await blogIndexApi(params);
      blogs.value = response.data.data;
      meta.value = response.data.meta;
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };

  const deleteBlog = async (id: number) => {
    loading.value = true;
    try {
      await blogDestroyApi(id);
    } catch (e) {
      console.error(e);
      throw e;
    } finally {
      loading.value = false;
    }
  };

  // --- Public (unauthenticated) ---
  const publicBlog = ref<Blog | null>(null);
  const publicBlogs = ref<Blog[]>([]);
  const publicMeta = ref<PaginationMeta>({ current_page: 1, last_page: 1, per_page: 12, total: 0, from: 1, to: 0 });
  const publicLoading = ref(false);

  const getPublicBlogs = async (params: { page?: number; 'filter[title]'?: string } = {}) => {
    publicLoading.value = true;
    try {
      const response = await publicBlogIndexApi(params);
      publicBlogs.value = response.data.data;
      publicMeta.value = response.data.meta;
    } catch (e) {
      console.error(e);
    } finally {
      publicLoading.value = false;
    }
  };

  const getPublicBlog = async (slug: string) => {
    publicLoading.value = true;
    publicBlog.value = null;
    try {
      const response = await publicBlogShowApi(slug);
      publicBlog.value = response.data.data;
    } catch (e) {
      console.error(e);
      throw e;
    } finally {
      publicLoading.value = false;
    }
  };

  return {
    blog, blogs, loading, meta,
    createBlog, getBlogs, getBlog, updateBlog, deleteBlog,
    publicBlog, publicBlogs, publicMeta, publicLoading,
    getPublicBlogs, getPublicBlog,
  };
});
