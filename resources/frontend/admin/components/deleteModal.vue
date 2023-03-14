<template>
  <div>
    <Modal v-model="getDeleteModalInfo.showDeleteModal" width="360" :closable="false">
      <template #header>
        <p style="color:#f60;text-align:center">
          <Icon type="ios-information-circle"></Icon>
          <span>Delete confirmation</span>
        </p>
      </template>
      <div style="text-align:center">
        <p>Are you sure you want to delete it?</p>
      </div>
      <template #footer>
        <Button type="error" size="large" :loading="getLoadingState('deleteLoadingState')" @click="deleteItem">Delete</Button>
        <Button type="primary" size="large" @click="closeModal">Close</Button>
      </template>
    </Modal>
  </div>
</template>
<script>
  import { mapGetters } from 'vuex';

  export default {
    data () {
      return {}
    },
    methods: {
      async deleteItem () {
        this.$store.dispatch('setLoadingStateAction', { type: 'deleteLoadingState', value: true });

        let deleteItem = this.getDeleteModalInfo;
        // console.log(deleteItem.deleteData);
        const deleteResult = await this.callApi(`admin/${deleteItem.deleteUrl}`, 'DELETE', deleteItem.deleteData);

        if (deleteResult.data.status) {
          this.$store.dispatch('setDeleteModalInfoAction', {
            showDeleteModal: false,
            deleteIndex: deleteItem.deleteIndex,
            deleteUrl: '',
            deleteData: null,
            isDeleted: true
          });

          this.successMsg(deleteResult.data.message);
        } else {
            switch (deleteResult.status) {
                case 404:
                  this.errorMsg(deleteResult.data.message);
              break;
            default:
              this.errorMsg();
          }
        }

        this.$store.dispatch('setLoadingStateAction', { type: 'deleteLoadingState', value: false });
      },
      closeModal () {
        this.$store.dispatch('setDeleteModalInfoAction', {
          showDeleteModal: false,
          deleteIndex: -1,
          deleteUrl: '',
          deleteData: null
        });
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
