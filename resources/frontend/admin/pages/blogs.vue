<template>
  <div>
    <h1 class="mt-5">Blogs requests:</h1>

    <Table border :loading="getLoadingState('loadingState')" :columns="columns" :data="blogs" no-data-text="No blogs found..." class="mt-5">
      <!-- <template #categories="{ row, index }"> -->
      <template #categories="{ row }">
        <Space wrap v-for="(category, index) in row.categories" :key="index">
          <Tag>{{ category.name }}</Tag>
        </Space>
      </template>
      <template #user="{ row }">
        {{ row.user.name }}
      </template>
      <template #action="{ row, index }">
          <Space wrap>
            <Button type="info" shape="circle" icon="md-information" @click="showInfo(row, index)"></Button>
            <Button type="success" shape="circle" icon="md-checkmark" :loading="getLoadingState('createLoadingState')" :disabled="getLoadingState('createLoadingState')" @click="showAccept(row, index)"></Button>
            <Button type="error" shape="circle" icon="md-close" @click="showDelete(row, index)"></Button>
          </Space>
        </template>
      </Table>

      <Modal v-model="showInfoModal" v-if="blogData" :closable="false">
        <template #header>
          <p style="color: rgb(30 192 107);text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>{{ blogData.title }}</span>
          </p>
        </template>
        <div style="text-align:center">
          <pre>{{ blogData.content }}</pre>
        </div>
        <template #footer>
          <Button type="success" size="large" :loading="getLoadingState('createLoadingState')" :disabled="getLoadingState('createLoadingState')" @click="acceptBlog">Accept</Button>
          <Button type="error" size="large" :loading="getLoadingState('deleteLoadingState')" :disabled="getLoadingState('deleteLoadingState')" @click="acceptBlog">Delete</Button>
          <Button type="default" size="large" @click="closeAcceptModal">Close</Button>
        </template>
      </Modal>

      <Modal v-model="showAcceptModal" width="360" :closable="false">
        <template #header>
          <p style="color: rgb(30 192 107);text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>Accpet confirmation</span>
          </p>
        </template>
        <div style="text-align:center">
          <p>Are you sure you want to accept this blog?</p>
        </div>
        <template #footer>
          <Button type="success" size="large" :loading="getLoadingState('createLoadingState')" :disabled="getLoadingState('createLoadingState')" @click="acceptBlog">Accept</Button>
          <Button type="default" size="large" @click="closeAcceptModal">Close</Button>
        </template>
      </Modal>

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
          { title: 'Title', key: 'title', align: 'center' },
          { title: 'Creator', key: 'user', slot: 'user', align: 'center' },
          { title: 'Categories', slot: 'categories', align: 'center' },
          { title: 'Created at', key: 'created_at', align: 'center' },
          { title: 'Actions', slot: 'action', width: 150, align: 'center' },
        ],
        blogs: [],
        showInfoModal: false,
        showAcceptModal: false,
        blogData: null,
        blogIndex: -1,
        blogId: -1,
      }
    },
    async created () {
      this.$store.dispatch('setLoadingStateAction', { type: 'loadingState', value: true });

      let fetchBlogsResult = await this.callApi('admin/blogs', 'GET');

      if (fetchBlogsResult.data.status) {
          this.blogs = fetchBlogsResult.data.data.data;
      } else {
        this.errorMsg();
      }

      console.log(this.blogs.data);
      this.$store.dispatch('setLoadingStateAction', { type: 'loadingState', value: false });
    },
    methods: {
      showInfo (blog, index) {
        this.showInfoModal = true;
        this.blogIndex = index;
        this.blogId = blog.id;
        this.blogData = blog;
        console.log(this.blogId, this.blogIndex);
      },
      showAccept (blog, index) {
        this.showAcceptModal = true;
        this.blogIndex = index;
        this.blogId = blog.id;
        console.log(this.blogId, this.blogIndex);
      },
      async acceptBlog () {
        this.$store.dispatch('setLoadingStateAction', { type: 'createLoadingState', value: true });

        const acceptBlogResult = await this.callApi(`admin/blogs/accept/${this.blogId}`, 'POST');

        if (acceptBlogResult.data.status) {
          this.blogs.splice(this.blogIndex, 1);
          this.successMsg('Blog accepted successfuly.');
        } else {
          switch (acceptBlogResult.status) {
            case 404:
              this.errorMsg('Blog not found.');
              break;
            default:
              this.errorMsg();
          }
        }

        this.closeAcceptModal();
        this.$store.dispatch('setLoadingStateAction', { type: 'createLoadingState', value: false });
      },
      closeAcceptModal () {
        this.showAcceptModal = false;
        this.blogId = -1;
        this.blogIndex = -1;
        this.blogData = null;
      },
      showDelete (row, index) {
        this.$store.dispatch('setDeleteModalInfoAction', {
          showDeleteModal: true,
          deleteIndex: index,
          deleteUrl: `blogs/delete/${row.id}`,
          deleteData: row,
          isDeleted: false
        });
      },
    },
    watch: {
      getDeleteModalInfo(obj) {
        if (obj.isDeleted) {
          this.blogs.splice(obj.deleteIndex, 1);

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
