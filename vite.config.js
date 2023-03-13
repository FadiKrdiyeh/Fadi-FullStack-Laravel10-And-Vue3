import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from 'vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'node_modules/bootstrap/scss/bootstrap.scss',
                'resources/scss/app.scss',
                'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
                'resources/frontend/app.js',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        })
    ],
});
