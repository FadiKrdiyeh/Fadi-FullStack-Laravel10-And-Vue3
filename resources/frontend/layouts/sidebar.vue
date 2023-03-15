<template>
  <!-- <div class="area"></div>
  <nav class="main-menu">
    <ul>
      <li v-for="(link, index) of links" :key="index">
        <router-link :to="link.path">
          <i :class="'fa fa-' + link.icon + ' fa-2x'"></i>
          <span class="nav-text"> {{ link.text }} </span>
        </router-link>
      </li>
    </ul>

    <ul class="logout" v-if="isAuth()">
      <li>
        <a href="#" @click="logout">
          <i class="fa fa-power-off fa-2x"></i>
          <span class="nav-text"> Logout </span>
        </a>
      </li>
    </ul>
  </nav> -->
  <h1>Sidebar...</h1>
</template>

<script>
  export default {
    // data () {
    //   return {
    //     links: [
    //       { text: 'Home', path: '/', icon: 'home' },
    //       { text: 'Dashboard', path: '/admin/dashboard', icon: 'dashboard' },
    //       { text: 'Categories', path: '/admin/categories', icon: 'bookmark-o' },
    //       { text: 'Test', path: '/test', icon: 'gears' }
    //     ]
    //   }
    // },
    // methods: {
    //   async logout () {
    //     const logoutResult = await this.callApi('admin/logout', 'GET');

    //     if (logoutResult.data.status) {
    //       this.successMsg('Logged out successfuly.');
    //       window.location = '/admin/login';
    //     } else {
    //       this.errorMsg();
    //     }
    //   }
    // },
    // created () {
    //   console.log(this.isAuth());
    // }
  }
</script>
