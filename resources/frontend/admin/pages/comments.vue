<template>
  <div>
    <h1 class="mt-5">Comments management:</h1>

    <Table border :loading="getLoadingState('loadingState')" :columns="columns" :data="comments.data" no-data-text="No comments found..." class="mt-5">
      <template #categories="{ row }">
        <Space wrap v-for="(category, index) in row.categories" :key="index">
          <Tag>{{ category.name }}</Tag>
        </Space>
      </template>
      <template #user="{ row }">
        {{ row.user.name }}
      </template>
      <template #blog="{ row }">
        {{ row.blog.title }}
      </template>
      <template #action="{ row, index }">
          <Space wrap>
            <Button type="error" shape="circle" icon="md-close" @click="showDelete(row, index)"></Button>
          </Space>
        </template>
      </Table>

      <Page :total="comments.total" :page-size="comments.per_page" class="mt-3 mb-5" @on-change="changePaginate" v-if="comments.total > comments.per_page" />

    <!-- Delete modal -->
    <delete-modal />
  </div>
</template>
<script>
  import { mapGetters } from 'vuex';
  import deleteModal from '../components/deleteModal.vue';

  export default {
    components: { deleteModal },
    data () {
      return {
        columns: [
          { title: '#', key: 'id', width: 150, align: 'center' },
          { title: 'Content', key: 'content', align: 'center' },
          { title: 'Creator', key: 'user', slot: 'user', align: 'center' },
          { title: 'Blog', slot: 'blog', align: 'center' },
          { title: 'Created at', key: 'created_at', align: 'center' },
          { title: 'Actions', slot: 'action', width: 150, align: 'center' },
        ],
        comments: [],
        commentIndex: -1,
        commentId: -1,
      }
    },
    async created () {
      this.$store.dispatch('setLoadingStateAction', { type: 'loadingState', value: true });

      let fetchCommentsResult = await this.callApi('admin/comments/all', 'GET');

      if (fetchCommentsResult.data.status) {
          this.comments = fetchCommentsResult.data.data;
      } else {
        this.errorMsg();
      }

      console.log(this.comments.data);
      this.$store.dispatch('setLoadingStateAction', { type: 'loadingState', value: false });
    },
    methods: {
      showDelete (row, index) {
        this.$store.dispatch('setDeleteModalInfoAction', {
          showDeleteModal: true,
          deleteIndex: index,
          deleteUrl: `comments/delete/${row.id}`,
          deleteData: row,
          isDeleted: false
        });
      },
      async changePaginate (page) {
        // console.log(page);

        this.$store.dispatch('setLoadingStateAction', { type: 'loadingState', value: true });

        let fetchCommentsPaginationResult = await this.callApi(`admin/comments/all?page=${ page }`, 'GET');

        if (fetchCommentsPaginationResult.data.status) {
            this.comments = fetchCommentsPaginationResult.data.data;
        } else {
          this.errorMsg();
        }

        console.log(this.comments.data);
        this.$store.dispatch('setLoadingStateAction', { type: 'loadingState', value: false });
      }
    },
    watch: {
      getDeleteModalInfo(obj) {
        if (obj.isDeleted) {
          this.comments.data.splice(obj.deleteIndex, 1);

          this.$store.dispatch('setDeleteModalInfoAction', {
            showDeleteModal: false,
            deleteIndex: -1,
            deleteUrl: '',
            deleteData: null,
            isDeleted: false
          });
        }
      }
    },
    computed: {
      ...mapGetters([
        'getLoadingState',
        'getDeleteModalInfo'
      ]),
    }
  }
</script>
