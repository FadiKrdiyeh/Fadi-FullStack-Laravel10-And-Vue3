import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
      // vue(),
      laravel({
          input: [
              'node_modules/font-awesome-scss/scss/font-awesome.scss',
              'node_modules/bootstrap/scss/bootstrap.scss',
              'resources/scss/app.scss',
              'node_modules/jquery/dist/jquery.min.js',
              'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
              'resources/js/app.js',
              'resources/frontend/app.js'
          ],
          refresh: true,
      }),
      vue({
        template: {
          // compilerOptions: {
          //   isCustomElement: (tag) => {
          //     // return tag.startsWith('ion-') // (return true)
          //     return true;
          //   }
          // },
          transformAssetUrls: {
              // The Vue plugin will re-write asset URLs, when referenced
              // in Single File Components, to point to the Laravel web
              // server. Setting this to `null` allows the Laravel plugin
              // to instead re-write asset URLs to point to the Vite
              // server instead.
              base: null,

              // The Vue plugin will parse absolute URLs and treat them
              // as absolute paths to files on disk. Setting this to
              // `false` will leave absolute URLs un-touched so they can
              // reference assets in the public directory as expected.
              includeAbsolute: false,
          },
        },
    }),
    ],
});
