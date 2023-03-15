<template>
  <div class="flex items-center justify-center w-screen h-screen p-10 space-x-6 bg-gray-300">
    <Component :is="layout"></Component>
  </div>
</template>

<script>
const DEFAULT_LAYOUT = "Default"

export default {
  data () {
    return {}
  },

  created () {
    const token = window.Laravel.csrfToken;
    const authUser = window.Laravel.authUser;

    this.$store.dispatch('setTokenAction', token);
    this.$store.dispatch('setAuthUserAction', authUser);
  },

  updated () {
    console.log(`${this.layout} is used!`);
  },

  mounted () {
    console.log('App running successfully!');
  },

  computed: {
    layout () {
      return (this.$route.meta.layout || DEFAULT_LAYOUT) + 'Layout';
    }
  }
}
</script>
