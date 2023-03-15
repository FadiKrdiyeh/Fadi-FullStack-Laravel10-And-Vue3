<template>
  <div>
    <!-- Call Header -->
    <app-header></app-header>

    <h1 class="text-center">Admin Layout</h1>

    <!-- Call Sidebar -->
    <app-sidebar v-if="isAdminAuth()"></app-sidebar>

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
import AppSidebar from './adminSidebar.vue';
import AppHeader from './adminHeader.vue';
import AppFooter from './adminFooter.vue';

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
