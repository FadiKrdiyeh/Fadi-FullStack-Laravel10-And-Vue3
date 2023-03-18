<template>
  <div>
    <h1 class="text-center mb-3" style="font-size: 50px;">Blogs</h1>
    <div class="text-center mb-5"><router-link to="/blogs/create"><Button type="primary">Create blog</Button></router-link></div>
    <div class="blogs-container" v-if="blogs">
      <div class="blog-item blog-{{ index }}" v-for="(blog, index) of blogs.data" :key="index">
        <div class="blog-header">
          <div class="blog-edit" v-if="blog.user.id == getAuthUser.id"><router-link :to="`/blogs/edit/${blog.id}`"><Button type="primary" shape="circle" icon="ios-create"></Button></router-link></div>
          <router-link :to="`/blogs/${blog.slug}`">
            <div class="blog-title">{{ blog.title }}</div>
          </router-link>
          <span class="blog-creator" v-if="blog.user.id == getAuthUser.id"><Tag color="magenta">{{ blog.user.name }}</Tag></span>
          <span class="blog-creator" v-else>{{ blog.user.name }}</span>
          <span class="separate">|</span>
          <span class="blog-date">{{ blog.created_at }}</span>
          <div class="blog-categories">
            <Tag v-for="(category, index) of blog.categories" :key="index">{{ category.name }}</Tag>
          </div>
        </div>
        <pre class="blog-content">{{ blog.content }}</pre>
        <div class="blog-footer">
          <div class="blog-comments">{{ blog.comments_count }} <i class="fa fa-comment fa-2x d-inline"></i></div>
        </div>
      </div>
      {{ blogs.total }}
      <Page :total="blogs.total" :page-size="blogs.per_page" class="d-block mt-3 mb-5" @on-change="changePaginate" v-if="blogs.total > blogs.per_page" />
    </div>
    <div v-else>
      <div class="alert alert-secondary text-center">No blogs at this moment... try create one <router-link to="/blogs/create"><Button type="primary">Create blog</Button></router-link></div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex';

  export default {
    data () {
      return {
        blogs: null,
      }
    },
    async created () {
      const fetchBlogsResult = await this.callApi('blogs', 'GET');

      if (fetchBlogsResult.data.status) {
        console.log(fetchBlogsResult.data.data);
        this.blogs = fetchBlogsResult.data.data;
        console.log('blogs ' , this.blogs);
      } else {
        this.errorMsg();
      }
    },
    methods: {
      async changePaginate (page) {
        const fetchBlogsResult = await this.callApi(`blogs?page=${ page }`, 'GET');

        if (fetchBlogsResult.data.status) {
          this.blogs = fetchBlogsResult.data.data;
        } else {
          this.errorMsg();
        }
      }
    },
    computed: {
      ...mapGetters(['getAuthUser']),
    }
  }
</script>
