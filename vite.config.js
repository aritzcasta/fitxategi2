import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: ['resources/**'],
        }),
    ],
    server: {
        hmr: {
            overlay: false
        },
        watch: {
            usePolling: true, // Important for Windows/UniServer
        }
    },
});
