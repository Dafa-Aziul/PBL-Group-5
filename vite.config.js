import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';


// export default defineConfig({
//     server: {
//         host: '0.0.0.0',             // Agar bisa diakses dari perangkat lain
//         port: 5173,
//         strictPort: true,
//         hmr: {
//             protocol: 'ws',          // Tambahkan ini (ws = WebSocket)
//             host: '192.168.1.8',     // IP lokal laptop kamu
//             port: 5173               // Wajib dicocokkan
//         }
//     },
//     plugins: [
//         laravel({
//             input: ['resources/sass/app.scss', 'resources/css/styles.css' ,'resources/js/app.js'],
//             refresh: true,
//         }),
//         tailwindcss(),
//     ],
// });

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/css/styles.css' ,'resources/js/app.js', 'resources/css/app.css'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
