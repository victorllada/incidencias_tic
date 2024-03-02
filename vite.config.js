import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/incidencias.js',
                'resources/js/usuarios.js',
                'resources/js/showIncidencia.js'
            ],
            refresh: true,
        }),
    ],
});
