<template>
  <div class="d-flex flex-column">
    <h1>Create blog <router-link to="/blogs"><Button type="primary">Back to blogs</Button></router-link></h1>
    <Input v-model="blog.title" placeholder="Enter blog title..." style="width: 300px" class="mt-3" />
    <Input v-model="blog.content" show-word-limit type="textarea" placeholder="Enter something..." style="width: 500px" class="mt-3" />
    <Select placeholder="Select categories" v-model="blog.categories" multiple filterable style="width:260px" class="mt-3">
        <Option v-for="category in categories" :value="category.id" :key="category.id">{{ category.name }}</Option>
    </Select>
    <Button @click="create" type="primary" class="mt-5" style="width: 200px" :loading="getLoadingState('createLoadingState')" :disabled="getLoadingState('createLoadingState')"><Icon type="ios-add"></Icon> Create blog</Button>
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
          title: '',
          content: '',
          categories: []
        }
      }
    },
    async created () {
      const getCategoriesResult = await this.callApi('categories', 'GET');

      if (getCategoriesResult.data.status) {
        this.categories = getCategoriesResult.data.data;
      } else {
        this.errorMsg('Couldnt load categories...');
      }
    },
    methods: {
      async create () {
        if (this.blog.title == '') return this.warningMsg('Blog title is required!');
        if (this.blog.content == '') return this.warningMsg('Blog content is required!');
        if (this.blog.categories.length == 0) return this.warningMsg('Choose at least one category!');

        this.$store.dispatch('setLoadingStateAction', { type: 'createLoadingState', value: true });

        const createBlogResult = await this.callApi('blogs', 'POST', this.blog);

        if (createBlogResult.data.status) {
          this.successMsg('Blog created successfuly. It will accepted by admin soonly if everything good.');
          this.$router.push('/blogs');
        } else {
          this.errorMsg();
        }

        this.$store.dispatch('setLoadingStateAction', { type: 'createLoadingState', value: false });
      }
    },
    computed: {
      ...mapGetters(['getLoadingState']),
    }
  }
</script>
