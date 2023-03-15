<template>
  <div class="d-flex flex-column">
    <h1>blogs create</h1>
    <Input v-model="blog.title" placeholder="Enter blog title..." style="width: 300px" class="mt-3" />
    <Input v-model="blog.content" maxlength="100" show-word-limit type="textarea" placeholder="Enter something..." style="width: 500px" class="mt-3" />
    <Select default-label="Select categories..." placeholder="Select categories" v-model="blog.categories" multiple filterable style="width:260px" class="mt-3">
        <Option v-for="category in categories" :value="category.id" :key="category.id">{{ category.name }}</Option>
    </Select>
    <Button @click="create" type="primary" class="mt-5" style="width: 200px"><Icon type="ios-add"></Icon> Create blog</Button>
  </div>
</template>

<script>
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

        const createBlogResult = await this.callApi('blogs', 'POST', this.blog);

        if (createBlogResult.data.status) {
          this.successMsg('Blog created successfuly.');
        } else {
          this.errorMsg();
        }
      }
    }
  }
</script>
