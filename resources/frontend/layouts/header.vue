<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light header default-header fixed-top" id="header">
    <div class="container-fluid">
      <router-link to="/" class="navbar-brand">{{ brand }}</router-link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav" v-if="isUserAuth()">
          <li class="nav-item" v-for="(link, index) of links" :key="index">
            <router-link :to="link.path" exact-active-class="router-active" class="nav-link">{{ link.text }}</router-link>
          </li>
        </ul>

        <ul class="ms-auto" v-if="isUserAuth()">
          <li class="nav-item">
            <a class="nav-link"><i class="fa fa-user d-inline me-2"></i> {{ getAuthUser.name }} <Icon type="md-exit" size="20" @click="logout"></Icon></a>
          </li>
        </ul>
        <ul class="ms-auto" v-else>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-user d-inline me-2"></i> Account
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
              <li><router-link class="dropdown-item" to="/register">Register</router-link></li>
              <li><router-link class="dropdown-item" to="/login">Login</router-link></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- <h1>Default Header...</h1> -->
</template>

<script>
  export default {
    name: 'Header',

    data () {
      return {
        brand: 'Fadi Krdiyeh',

        links: [
          { text: 'Home', path: '/' },
          { text: 'Blogs', path: '/blogs' },
          // { text: 'Test', path: '/test' },
        ],
      }
    },
    created () {
      // console.log(this.isUserAuth());
    },
    methods: {
      async logout () {
        const logoutResult = await this.callApi('logout', 'GET');

        if (logoutResult.data.status) {
          this.successMsg('Logged out successfuly.');
          window.location = '/login';
        } else {
          this.errorMsg();
        }
      }
    },
  }
</script>
