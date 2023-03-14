<template>
  <div>
    <h1 class="my-5">Dashboard...</h1>
    <Grid :border="true" :hover="true" center square class="mb-5">
      <GridItem center="true">
        Categories count: <Tag color="cyan"><CountUp :end="categoriesCount" :duration="3" ref="count" v-font="24" /></Tag>
      </GridItem>
      <GridItem>
        Users count: <Tag color="gold"><CountUp :end="usersCount" :duration="3" ref="count" v-font="24" /></Tag>
      </GridItem>
      <GridItem>
        Blogs count: <Tag color="magenta"><CountUp :end="blogsCount" :duration="3" ref="count" v-font="24" /></Tag>
      </GridItem>
      <GridItem>
        Comments count: <Tag color="geekblue"><CountUp :end="commentsCount" :duration="3" ref="count" v-font="24" /></Tag>
      </GridItem>
  </Grid>
  </div>
</template>
<script>
  export default {
    data () {
      return {
        categoriesCount: 0,
        usersCount: 0,
        blogsCount: 1925,
        commentsCount: 29874623
      }
    },

    async created () {
      // , countBlogsResult, countCommentsResult
      const [countCategoriesResult, countUsersResult] = await Promise.all([
        this.callApi('admin/count-categories', 'GET'),
        this.callApi('admin/count-users', 'GET'),
      ]);

      if (countCategoriesResult.data.status) {
        this.categoriesCount = countCategoriesResult.data.data;
      } else {
        this.errorMsg('Couldnt count categories!');
      }

      if (countUsersResult.data.status) {
        this.usersCount = countUsersResult.data.data;
      } else {
        this.errorMsg('Couldnt count users!');
      }
    }
  }
</script>
