<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light header" id="header">
      <div class="container-fluid">
        <router-link to="/" class="navbar-brand">{{ brand }}</router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item" v-for="(link, index) of links" :key="index">
              <router-link :to="link.path" exact-active-class="router-active" class="nav-link">{{ link.text }}</router-link>
            </li>
          </ul>
          <ul class="ms-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user d-inline me-2"></i> Account
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink" v-if="isLoggedIn">
                <li><a class="dropdown-item" href="#">Logout</a></li>
              </ul>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink" v-else>
                <li><a class="dropdown-item" href="#">Register</a></li>
                <li><a class="dropdown-item" href="#">Login</a></li>
              </ul>
            </li>
          </ul>
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
          { text: 'Home', path: '/' },
          { text: 'Test', path: '/test' },
        ],
        isLoggedIn: false,
      }
    },
  }
</script>
