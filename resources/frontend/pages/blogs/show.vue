<template>
  <div>
    <div class="text-center mb-5"><router-link to="/blogs"><Button type="primary">Back to blogs</Button></router-link></div>
    <div class="blogs-container">
      <div class="blog-item blog" v-if="!getLoadingState('loadingState')">
        <div class="blog-header">
          <div class="blog-edit" v-if="blog.user_id == getAuthUser.id"><router-link :to="`/blogs/edit/${blog.id}`"><Button type="primary" shape="circle" icon="ios-create"></Button></router-link></div>
          <div class="blog-title">{{ blog.title }}</div>
          <span class="blog-creator" v-if="blog.user_id == getAuthUser.id"><Tag color="magenta">{{ blog.user.name }}</Tag></span>
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
    </div>

    <div v-if="!getLoadingState('loadingState')">
      <div class="comments-container" v-if="comments.data.length > 0">
        <Button @click="loadMoreComments(++comments.current_page)" :loading="getLoadingState('fetchingLoadingState')" :disabled="comments.current_page >= comments.last_page"><Icon type="md-refresh" /> Load more comments...</Button>
        <div class="comment-item" v-for="(comment, index) of comments.data" :key="index">
          <h3 class="comment-title">{{ comment.user.name }} | <span style="font-size: 12px;" class="comment-data">{{ comment.created_at }}</span></h3>
          <p class="comment-content">{{ comment.content }}</p>
        </div>
      </div>
      <div class="alert alert-secondary" v-else>No comments yet...</div>
    </div>

    <div class="add-comment-container d-block">
      <Input v-model="commentContent" type="textarea" placeholder="Enter something..." style="width: 500px" class="mt-3 d-block" />
      <Button @click="comment" type="primary" class="my-2" style="width: 200px" :loading="getLoadingState('createLoadingState')" :disabled="getLoadingState('createLoadingState')"><i class="fa fa-comment fa-2x d-inline"></i> Add comment</Button>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex';

  export default {
    data () {
      return {
        blog: {},
        comments: [],
        commentContent: ''
      }
    },
    async created () {
      this.$store.dispatch('setLoadingStateAction', { type: 'loadingState', value: true });

      const fetchBlogResult = await this.callApi(`blogs/${ this.$route.params.slug }`, 'GET');

      if (fetchBlogResult.data.status) {
        this.blog = fetchBlogResult.data.data[0];
      } else {
        this.errorMsg('Couldnt load blog data.');
      }

      const fetchBlogCommentsResult = await this.callApi(`comments/${this.blog.id}`, 'GET');

      if (fetchBlogCommentsResult.data.status) {
        this.comments = fetchBlogCommentsResult.data.data;
        this.comments.data = this.comments.data.reverse();
      } else {
        this.errorMsg('Couldnt load comments.');
      }

      this.$store.dispatch('setLoadingStateAction', { type: 'loadingState', value: false });
    },
    methods: {
      async loadMoreComments (page) {
        this.$store.dispatch('setLoadingStateAction', { type: 'fetchingLoadingState', value: true });

        const loadMoreCommentsResult = await this.callApi(`comments/${this.blog.id}?page=${ page }`, 'GET');

        if (loadMoreCommentsResult.data.status) {
          let loadedComments = loadMoreCommentsResult.data.data.data;

          console.log(loadedComments);
          console.log(this.comments);
          this.comments.data.unshift(...loadedComments.reverse());

          // this.comments.data = this.comments.data.reverse();
        } else {
          this.errorMsg('Couldnt load comments.');
        }

        this.$store.dispatch('setLoadingStateAction', { type: 'fetchingLoadingState', value: false });
      },
      async comment () {
        this.$store.dispatch('setLoadingStateAction', { type: 'createLoadingState', value: true });

        const addCommentResult = await this.callApi('comments', 'POST', { content: this.commentContent, blog_id: this.blog.id, user_id: this.blog.user_id });

        if (addCommentResult.data.status) {
          this.successMsg('Comment added successfuly.');
          this.commentContent = '';
          this.comments.data.push(addCommentResult.data.data);
          console.log(addCommentResult.data.data);
          ++this.blog.comments_count;
        } else {
          this.errorMsg();
        }

        this.$store.dispatch('setLoadingStateAction', { type: 'createLoadingState', value: false });
      }
    },
    computed: {
      ...mapGetters(['getAuthUser', 'getLoadingState']),
    }
  }
</script>
