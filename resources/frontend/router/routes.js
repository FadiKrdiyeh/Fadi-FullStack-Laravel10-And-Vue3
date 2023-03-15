// User components...
import homePage from './../pages/home.vue';
import userLoginPage from './../pages/auth/login.vue'
import userRegisterPage from './../pages/auth/register.vue'

import createBlogPage from './../pages/blogs/create.vue'

// Admin components...
import adminLoginPage from './../admin/pages/auth/login.vue';
import adminRegisterPage from './../admin/pages/auth/register.vue';
import dashboardPage from './../admin/pages/dashboard.vue';
import categoriesPage from './../admin/pages/categories.vue';
import postsPage from './../admin/pages/posts.vue';
import commentsPage from './../admin/pages/comments.vue';
import usersPage from './../admin/pages/users.vue';

import testPage from './../pages/test.vue';

const routes = [
  { path: '/', name: 'root', component: homePage },
  { path: '/home', name: 'home', component: homePage },
  { path: '/login', name: 'login', component: userLoginPage },
  { path: '/register', name: 'register', component: userRegisterPage },

  { path: '/blogs/create', name: 'createBlog', component: createBlogPage },

  // Admin routes....
  {
    path: '/admin',
    children: [
      { path: 'login', component: adminLoginPage },
      { path: 'register', component: adminRegisterPage },
      { path: 'dashboard', component: dashboardPage },
      { path: 'posts', component: postsPage },
      { path: 'comments', component: commentsPage },
      { path: 'categories', component: categoriesPage },
      { path: 'users', component: usersPage },
    ],
    meta: { layout: 'Admin' }
  },

  // User routes....
  { path: '/test', name: 'test', component: testPage },
  // { path: '/test', component: test }
]
export default routes;
