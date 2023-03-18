<template>
  <div>
    <h1 class="mt-5">Users management: <router-link to="/admin/register"><Button icon="md-add">Add Admin</Button></router-link></h1>

    <Table border :loading="getLoadingState('loadingState')" :columns="columns" :data="users" no-data-text="No users found..." class="mt-5">
      <template #type="{ row }">
        <Tag color="magenta" v-if="row.type == 'admin'">{{ row.type }}</Tag>
        <span v-else>{{ row.type }}</span>
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
          { title: 'Name', key: 'name', align: 'center' },
          { title: 'Email', key: 'email', align: 'center' },
          { title: 'Type', key: 'type', slot: 'type', align: 'center' },
          { title: 'Created at', key: 'created_at', align: 'center' },
          { title: 'Actions', slot: 'action', width: 150, align: 'center' },
        ],
        users: [],
        userIndex: -1,
        userId: -1,
      }
    },
    async created () {
      this.$store.dispatch('setLoadingStateAction', { type: 'loadingState', value: true });

      let fetchUsersResult = await this.callApi('admin/users/all', 'GET');

      if (fetchUsersResult.data.status) {
          this.users = fetchUsersResult.data.data;
      } else {
        this.errorMsg();
      }

      console.log(this.users.data);
      this.$store.dispatch('setLoadingStateAction', { type: 'loadingState', value: false });
    },
    methods: {
      showDelete (row, index) {
        this.$store.dispatch('setDeleteModalInfoAction', {
          showDeleteModal: true,
          deleteIndex: index,
          deleteUrl: `users/delete/${row.id}`,
          deleteData: row,
          isDeleted: false
        });
      },
    },
    watch: {
      getDeleteModalInfo(obj) {
        if (obj.isDeleted) {
          this.users.splice(obj.deleteIndex, 1);

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
