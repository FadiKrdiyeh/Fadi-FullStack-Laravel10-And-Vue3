<template>
  <div>
    <h1 class="mt-5">Categories: <Button icon="md-add" @click="createModal = true">Add Category</Button></h1>

    <Table border :loading="getLoadingState('loadingState')" :columns="columns" :data="categories" no-data-text="No categories found..." class="mt-5">
      <template #action="{ row, index }">
          <Space wrap>
            <Button type="primary" shape="circle" icon="md-create" @click="showEdit(row, index)"></Button>
            <Button type="error" shape="circle" icon="md-trash" @click="showDelete(row, index)"></Button>
          </Space>
        </template>
      </Table>

    <!-- Create modal -->
    <Modal v-model="createModal" draggable sticky scrollable :mask="false" title="Create category">
      <div>
        <Input v-model="createData.name" maxlength="50" show-word-limit placeholder="Category name..." />
      </div>
      <template #footer>
        <Button type="primary" size="large" :loading="getLoadingState('createLoadingState')" @click="create">Create</Button>
        <Button type="error" size="large" @click="closeCreateModal">Close</Button>
      </template>
    </Modal>

    <!-- Edit modal -->
    <Modal v-model="editModal" draggable sticky scrollable :mask="false" title="Edit category">
      <div>
        <Input v-model="editData.name" maxlength="50" show-word-limit placeholder="Category name..." />
      </div>
      <template #footer>
        <Button type="primary" size="large" :loading="getLoadingState('editLoadingState')" @click="edit">Update</Button>
        <Button type="error" size="large" @click="closeEditModal">Close</Button>
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
          { title: 'Name', key: 'name', align: 'center' },
          { title: 'Created at', key: 'created_at', align: 'center' },
          { title: 'Actions', slot: 'action', width: 150, align: 'center' },
        ],
        categories: [],
        createModal: false,
        createData: {
          name: ''
        },
        editModal: false,
        editData: {
          id: -1,
          name: ''
        },
        editIndex: -1,
      }
    },
    async created () {
      this.$store.dispatch('setLoadingStateAction', { type: 'loadingState', value: true });

      let fetchCategoriesResult = await this.callApi('admin/categories', 'GET');

      if (fetchCategoriesResult.data.status) {
          this.categories = fetchCategoriesResult.data.data;
      } else {
        this.errorMsg();
      }

      this.$store.dispatch('setLoadingStateAction', { type: 'loadingState', value: false });
    },
    methods: {
      async create () {
        this.$store.dispatch('setLoadingStateAction', { type: 'createLoadingState', value: true });
        const createResult = await this.callApi('admin/categories', 'POST', this.createData);

        if (createResult.data.status) {
          this.categories.unshift(createResult.data.data);
          this.successMsg('Category created successfuly!');
        } else {
          this.errorMsg();
        }

        this.closeCreateModal();
        this.$store.dispatch('setLoadingStateAction', { type: 'createLoadingState', value: false });
      },
      showEdit (row, index) {
        this.editData.id = row.id;
        this.editData.name = row.name;
        this.editIndex = index;
        this.editModal = true;
      },
      async edit () {
        this.$store.dispatch('setLoadingStateAction', { type: 'editLoadingState', value: true });

        console.log(this.editData);
        const editResult = await this.callApi(`admin/categories/${this.editData.id}`, 'PUT', this.editData);

        if (editResult.data.status) {
          this.categories[this.editIndex] = editResult.data.data;
          this.successMsg('Category updated successfuly!');
        } else {
          switch (editResult.status) {
            case 404:
              this.errorMsg(editResult.data.message);
              break;
            default:
              this.errorMsg();
              break;
          }
        }
        this.closeEditModal();
        this.$store.dispatch('setLoadingStateAction', { type: 'editLoadingState', value: false });
      },
      showDelete (row, index) {
        this.$store.dispatch('setDeleteModalInfoAction', {
          showDeleteModal: true,
          deleteIndex: index,
          deleteUrl: `categories/${row.id}`,
          deleteData: row,
          isDeleted: false
        });
      },
      closeCreateModal () {
        this.createModal = false;
        this.createData.name = '';
      },
      closeEditModal () {
        this.editModal = false;
        this.editData.name = '';
        this.editData.id = -1;
        this.editIndex = -1;
      },
    },
    watch: {
      getDeleteModalInfo(obj) {
        if (obj.isDeleted) {
          this.categories.splice(obj.deleteIndex, 1);

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
