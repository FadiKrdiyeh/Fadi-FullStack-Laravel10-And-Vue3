<template>
  <div class="flex items-center justify-center w-screen h-screen p-10 space-x-6 bg-gray-300">
    <!-- Call Header -->
    <app-header></app-header>

    <!-- Call Sidebar -->
    <app-sidebar></app-sidebar>

    <!-- For routing -->
    <div class="container">
      <!-- <transition name="router-animation">
        <router-view></router-view>
      </transition> -->
      <router-view v-slot="{ Component }">
        <transition name="fade" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </div>

    <!-- Call Footer -->
    <app-footer></app-footer>
  </div>
</template>

<script>
import AppSidebar from './sidebar.vue';
import AppHeader from './header.vue';
import AppFooter from './footer.vue';
// import { mapGetters } from 'vuex';

export default {
  props: ['user'],
  data () {
    return {}
  },

  components: { AppHeader, AppFooter, AppSidebar },

  created () {
    const token = window.Laravel.csrfToken;
    const authUser = window.Laravel.authUser;

    this.$store.dispatch('setTokenAction', token);
    this.$store.dispatch('setAuthUserAction', authUser);
  },

  mounted () {
    console.log('App running successfully!');
  },
  // computed: {
  //   ...mapGetters([
  //     'getAuthUser'
  //   ])
  // }
}
</script>
<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
