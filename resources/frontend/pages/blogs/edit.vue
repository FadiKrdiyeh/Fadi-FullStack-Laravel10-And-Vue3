<template>
  <div class="d-flex flex-column">
    <h1>Edit blog <router-link to="/blogs"><Button type="primary">Back to blogs</Button></router-link></h1>
    <Input v-model="blog.title" placeholder="Enter blog title..." style="width: 300px" class="mt-3" />
    <Input v-model="blog.content" type="textarea" placeholder="Enter something..." style="width: 500px" class="mt-3" />
    <Select placeholder="Select categories" v-model="blog.categories_id" multiple filterable style="width:260px" class="mt-3">
        <Option v-for="category of categories" :value="category.id" :key="category.id">{{ category.name }}</Option>
    </Select>
    <Button @click="update" type="primary" class="mt-5" style="width: 200px" :loading="getLoadingState('editLoadingState')" :disabled="getLoadingState('editLoadingState')"><Icon type="ios-create"></Icon> Update blog</Button>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex';

  export default {
    // components: { editor }
    data () {
      return {
        categories: [],
        blog: {
          id: -1,
          title: '',
          content: '',
          categories_id: []
        }
      }
    },
    async created () {
      // const getCategoriesResult = await this.callApi('categories', 'GET');
      const [getBlogResult, getCategoriesResult] = await Promise.all([
        this.callApi(`blogs/${ this.$route.params.id }/edit`, 'GET'),
        this.callApi('categories', 'GET'),
      ]);

      if (getBlogResult.data.status) {
        // this.blog = getBlogResult.data.data;
        this.blog.id = getBlogResult.data.data.id;
        this.blog.title = getBlogResult.data.data.title;
        this.blog.content = getBlogResult.data.data.content;
        // console.log(this.blog);
        for (let category of getBlogResult.data.data.categories) {
          this.blog.categories_id.push(category.id);
        }
      } else {
        this.errorMsg('Couldnt load blog data...');
      }

      if (getCategoriesResult.data.status) {
        this.categories = getCategoriesResult.data.data;
      } else {
        this.errorMsg('Couldnt load categories...');
      }
    },
    methods: {
      async update () {
        if (this.blog.title == '') return this.warningMsg('Blog title is required!');
        if (this.blog.content == '') return this.warningMsg('Blog content is required!');
        if (this.blog.categories_id.length == 0) return this.warningMsg('Choose at least one category!');

        this.$store.dispatch('setLoadingStateAction', { type: 'editLoadingState', value: true });
        console.log(this.$route.params.id);
        const updateBlogResult = await this.callApi(`blogs/${this.$route.params.id}`, 'PUT', this.blog);

        if (updateBlogResult.data.status) {
          this.successMsg('Blog updated successfuly.');
          this.$router.push('/blogs');
        } else {
          this.errorMsg();
        }

        this.$store.dispatch('setLoadingStateAction', { type: 'editLoadingState', value: false });
      }
    },
    computed: {
      ...mapGetters(['getLoadingState']),
    }
  }
</script>
