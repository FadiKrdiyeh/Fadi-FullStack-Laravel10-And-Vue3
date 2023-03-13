<template>
  <div class="area"></div>
  <nav class="main-menu">
    <ul>
      <li v-for="(link, index) of links" :key="index">
        <router-link :to="link.path">
          <i :class="'fa fa-' + link.icon + ' fa-2x'"></i>
          <span class="nav-text"> {{ link.text }} </span>
        </router-link>
      </li>
    </ul>

    <ul class="logout">
      <li>
        <a href="#">
          <i class="fa fa-power-off fa-2x"></i>
          <span class="nav-text"> Logout </span>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
  export default {
    data () {
      return {
        links: [
          { text: 'Home', path: '/', icon: 'home' },
          { text: 'Dashboard', path: 'dashboard', icon: 'dashboard' },
          { text: 'Categories', path: 'categories', icon: 'bookmark-o' },
          { text: 'Test', path: 'test', icon: 'gears' }
        ]
      }
    }
  }
</script>
