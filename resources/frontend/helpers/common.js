import axios from "axios";
import { mapGetters } from "vuex";

export default {
  data () {
    return {}
  },
  methods: {
    async callApi (url, method, dataObj) {
      try {
        return await axios({
          url: `/app/${url}`,
          method: method,
          data: dataObj
        });
      } catch (error) {
        return error.response;
      }
    },

    isUserAuth () {
      return this.getAuthUser != null && this.getAuthUser.type == 'user' ? true : false;
    },
    isAdminAuth () {
      return this.getAuthUser != null && this.getAuthUser.type == 'admin' ? true : false;
    },

    // Messages
    successMsg (message, title = "Greate!") {
      this.$Notice.success({
        title: title,
        desc: message
      });
    },

    infoMsg (message, title = "Hey!") {
      this.$Notice.info({
        title: title,
        desc: message
      });
    },

    warningMsg (message, title = "Hmmmm!") {
      this.$Notice.warning({
        title: title,
        desc: message
      });
    },

    errorMsg (message = 'Something went wrong!', title = "Oops!") {
      this.$Notice.error({
        title: title,
        desc: message
      });
    },
  },
  computed: {
    ...mapGetters(['getAuthUser']),
  }
}
