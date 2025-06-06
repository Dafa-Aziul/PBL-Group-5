import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input:
                [
                    'resources/sass/app.scss',
                    'resources/css/styles.css',
                    'resources/js/app.js',
                    'resources/js/scripts.js',
                    'resources/js/select2.js',
                    'resources/js/chart.js',
                ],
            refresh: true,
            resolve: {
                alias: {
                    $: 'jquery',
                    jQuery: 'jquery',
                },
            },
        }),

        tailwindcss(),
    ],
});
