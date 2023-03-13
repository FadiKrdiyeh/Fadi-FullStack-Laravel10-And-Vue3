<template>
  <div class="flex items-center justify-center w-screen h-screen p-10 space-x-6 bg-gray-300">
    <!-- Call Header -->
    <app-header></app-header>

    <!-- Call Sidebar -->
    <app-sidebar></app-sidebar>

    <!-- For routing -->
    <div class="container">
      <router-view></router-view>
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
  // name: 'main-app',
  components: {AppHeader, AppFooter, AppSidebar},

  mounted () {
    console.log('App running successfully!');
  }
}
</script>
