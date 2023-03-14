import homePage from './../pages/home.vue';
import loginPage from './../admin/pages/auth/login.vue';
import registerPage from './../admin/pages/auth/register.vue';
import categoriesPage from './../admin/pages/categories.vue';
import dashboardPage from './../admin/pages/dashboard.vue';
import testPage from './../pages/test.vue';

const routes = [
  { path: '/', name: 'home', component: homePage },
  // Admin routes....
  {
    path: '/admin',
    children: [
      { path: 'login', component: loginPage },
      { path: 'register', component: registerPage },
      { path: 'categories', component: categoriesPage },
      { path: 'dashboard', component: dashboardPage }
    ]
  },

  // User routes....
  { path: '/test', name: 'test', component: testPage },
  // { path: '/test', component: test }
]
export default routes;
