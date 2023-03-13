<template>
  <div class="d-flex justify-content-center align-items-center h-100 mt-5">
    <div class="table-responsive w-100" v-if="categories.length > 0">
    <table class="table table-striped table-hover text-center">
      <thead>
        <tr>
          <th>#</th>
          <th>Category Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(category, index) of categories" :key="index">
          <td>{{ category.id }}</td>
          <td>{{ category.name }}</td>
          <td><button class="btn btn-primary">edit</button></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="alert alert-info w-50 text-center" v-else>No categories found!</div>
  </div>
</template>
<script>
  export default {
    data () {
      return {
        categories: []
      }
    },
    async created () {
      let fetchCategoriesResult = await this.callApi('categories', 'GET');
      console.log(fetchCategoriesResult.data.status);

      if (fetchCategoriesResult.data.status) {
        this.categories = fetchCategoriesResult.data.data;
      }
    }
  }
</script>
