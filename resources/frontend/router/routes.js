import homePage from './../pages/home.vue';
import categoriesPage from './../admin/pages/categories.vue';
import testPage from './../pages/test.vue';

const routes = [
  { path: '/', name: 'home', component: homePage },
  { path: '/categories', name: 'categories', component: categoriesPage },
  { path: '/test', name: 'test', component: testPage },
  // { path: '/test', component: test }
]
export default routes;
