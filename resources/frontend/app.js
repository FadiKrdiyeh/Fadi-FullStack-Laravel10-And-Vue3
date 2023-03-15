import '../js/bootstrap.js';
import { createApp } from 'vue';
import ViewUIPlus from 'view-ui-plus';
import app from './app.vue';

import DefualtLayout from './layouts/defaultLayout.vue';
import AdminLayout from './admin/layouts/adminLayout.vue';
import router from "./router/router";
import store from './store.js';
import 'view-ui-plus/dist/styles/viewuiplus.css';
import common from './helpers/common';
// import Editor from 'vue-editor-js';

// import fontawesome from '@fortawesome/fontawesome';
// import regular from '@fortawesome/free-regular-svg-icons';
// import solid from '@fortawesome/free-solid-svg-icons';
// import brands from '@fortawesome/free-brands-svg-icons';

createApp(app)
  .component('DefaultLayout', DefualtLayout)
  .component('AdminLayout', AdminLayout)
  .use(router)
  .use(store)
  .use(ViewUIPlus)
  // .use(Editor)
  .mixin(common)
  .mount('#fadiApp');
