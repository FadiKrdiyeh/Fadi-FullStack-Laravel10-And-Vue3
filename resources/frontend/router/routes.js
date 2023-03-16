// User components...
import homePage from './../pages/home.vue';
import userLoginPage from './../pages/auth/login.vue'
import userRegisterPage from './../pages/auth/register.vue'

import indexBlogPage from './../pages/blogs/index.vue'
import showBlogPage from './../pages/blogs/show.vue'
import createBlogPage from './../pages/blogs/create.vue'
import editBlogPage from './../pages/blogs/edit.vue'

// Admin components...
import adminLoginPage from './../admin/pages/auth/login.vue';
import adminRegisterPage from './../admin/pages/auth/register.vue';
import dashboardPage from './../admin/pages/dashboard.vue';
import categoriesPage from './../admin/pages/categories.vue';
import blogsPage from './../admin/pages/blogs.vue';
import commentsPage from './../admin/pages/comments.vue';
import usersPage from './../admin/pages/users.vue';

import testPage from './../pages/test.vue';

const routes = [
  { path: '/', name: 'root', component: homePage },
  { path: '/home', name: 'home', component: homePage },
  { path: '/login', name: 'login', component: userLoginPage },
  { path: '/register', name: 'register', component: userRegisterPage },

  { path: '/blogs', name: 'blogs.index', component: indexBlogPage },
  { path: '/blogs/:slug', name: 'blogs.show', component: showBlogPage },
  { path: '/blogs/create', name: 'createBlog', component: createBlogPage },
  { path: '/blogs/edit/:id', name: 'editBlog', component: editBlogPage },

  // Admin routes....
  {
    path: '/admin',
    children: [
      { path: 'login', component: adminLoginPage },
      { path: 'register', component: adminRegisterPage },
      { path: 'dashboard', component: dashboardPage },
      { path: 'blogs', component: blogsPage },
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
