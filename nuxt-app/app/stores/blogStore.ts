import { blogIndexApi, blogStoreApi } from "~/services/blogs";
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
  const values = { blog, blogs, loading, createBlog, getBlogs };
  return values;
});
