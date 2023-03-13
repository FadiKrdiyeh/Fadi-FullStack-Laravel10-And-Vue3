import axios from "axios";

export default {
  data () {
    return {}
  },
  methods: {
    async callApi (url, method, dataObj) {
      try {
        return await axios({
          url: `app/${url}`,
          method: method,
          data: dataObj
        });
      } catch (error) {
        return error.response;
      }
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

    errorMsg (message, title = "Oops!") {
      this.$Notice.error({
        title: title,
        desc: message
      });
    }
  }
}
