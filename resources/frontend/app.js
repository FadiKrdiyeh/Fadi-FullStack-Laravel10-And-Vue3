import '../js/bootstrap.js';
import { createApp } from 'vue';
import ViewUIPlus from 'view-ui-plus';
import app from './layouts/app.vue';
import router from "./router/router";
import 'view-ui-plus/dist/styles/viewuiplus.css';
import common from './helpers/common';
import fontawesome from '@fortawesome/fontawesome';
// import regular from '@fortawesome/free-regular-svg-icons';
// import solid from '@fortawesome/free-solid-svg-icons';
// import brands from '@fortawesome/free-brands-svg-icons';

createApp(app)
  .use(router)
  .use(ViewUIPlus)
  .mixin(common)
  .mount('#fadiApp');
