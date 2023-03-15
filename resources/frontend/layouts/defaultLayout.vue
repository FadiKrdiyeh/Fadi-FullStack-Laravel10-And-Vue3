<template>
  <div class="flex items-center justify-center w-screen h-screen p-10 space-x-6 bg-gray-300">
    <!-- Call Header -->
    <app-header></app-header>

    <h1 class="text-center">Default Layout</h1>

    <!-- Call Sidebar -->
    <app-sidebar></app-sidebar>

    <!-- For routing -->
    <div class="container">
      <router-view v-slot="{ Component }">
        <transition name="fade" mode="out-in">
          <Component :is="Component" />
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

export default {
  data () {
    return {}
  },

  components: { AppHeader, AppFooter, AppSidebar },

  // created () {
  //   const token = window.Laravel.csrfToken;
  //   const authUser = window.Laravel.authUser;

  //   this.$store.dispatch('setTokenAction', token);
  //   this.$store.dispatch('setAuthUserAction', authUser);
  // },
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
