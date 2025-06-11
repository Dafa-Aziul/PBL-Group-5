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
                    'resources/js/fas-all.js'
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
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    chart: ['resources/js/chart.js'],
                    select2: ['resources/js/select2.js'],
                    summernote: ['resources/js/summernote.js'],
                    bootstrap: ['resources/js/bootstrap.js'],
                }
            }
        }
    }
});
