import {
  blogIndexApi,
  blogShowApi,
  blogStoreApi,
  blogUpdateApi,
} from "~/services/blogs";
import type { Blog, BlogStoreData } from "~/types/blogTypes";

export const useBlogStore = defineStore("blog", () => {
  const blog = ref<Blog | null>(null);
  const blogs = ref<Blog[]>([]);
  const loading = ref(false);

  const createBlog = async (data: BlogStoreData) => {
    loading.value = true;
    try {
      const response = await blogStoreApi(data);
      await getBlogs();
      console.log(response);
    } catch (e) {
      console.error(e);
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
  const getBlogs = async () => {
    loading.value = true;
    try {
      const response = await blogIndexApi();
      blogs.value = response.data.data;
      console.log(response);
    } catch (e) {
      console.error(e);
    } finally {
      loading.value = false;
    }
  };
  const values = {
    blog,
    blogs,
    loading,
    createBlog,
    getBlogs,
    getBlog,
    updateBlog,
  };
  return values;
});
