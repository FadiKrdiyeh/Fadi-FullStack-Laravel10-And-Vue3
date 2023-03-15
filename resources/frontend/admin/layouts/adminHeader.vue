<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light header admin-header" id="header">
    <div class="container-fluid">
      <router-link to="/" class="navbar-brand">{{ brand }}</router-link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav" v-if="isAdminAuth()">
          <li class="nav-item" v-for="(link, index) of links" :key="index">
            <router-link :to="link.path" exact-active-class="router-active" class="nav-link">{{ link.text }}</router-link>
          </li>
        </ul>

        <ul class="ms-auto d-flex" v-if="isAdminAuth()">
          <li class="nav-item me-5">
            <span v-if="isAdminAuth()">Welcome admin.. </span>
          </li>
          <li class="nav-item">
            <a class="nav-link"><i class="fa fa-user d-inline me-2"></i> {{ getAuthUser.name }} <Icon type="ios-log-out" size="20" @click="logout"></Icon></a>
          </li>
        </ul>
        <!-- <ul class="ms-auto" v-else>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-user d-inline me-2"></i> Account
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink" v-if="isLoggedIn">
              <li><a class="dropdown-item" href="#">Logout</a></li>
            </ul>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="#">Register</a></li>
              <li><a class="dropdown-item" href="#">Login</a></li>
            </ul>
          </li>
        </ul> -->
      </div>
    </div>
  </nav>
</template>

<script>
  export default {
    name: 'Header',

    data () {
      return {
        brand: 'Fadi Krdiyeh',

        links: [
          { text: 'Dashboard', path: '/admin/dashboard' },
          { text: 'Posts', path: '/admin/posts' },
          { text: 'Comments', path: '/admin/comments' },
          { text: 'Categories', path: '/admin/categories' },
          { text: 'Users', path: '/admin/users' },
        ],
      }
    },

    methods: {
      async logout () {
        const logoutResult = await this.callApi('admin/logout', 'GET');

        if (logoutResult.data.status) {
          this.successMsg('Logged out successfuly.');
          window.location = '/admin/login';
        } else {
          this.errorMsg();
        }
      }
    },
  }
</script>
