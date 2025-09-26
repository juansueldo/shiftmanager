import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(({ command }) => {
    const isProduction = command === 'build';

    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: !isProduction, // HMR solo en desarrollo
            }),
            tailwindcss(),
        ],
        build: {
            manifest: true,       // obligatorio para Laravel en producción
            outDir: 'public/build',
            emptyOutDir: true,    // limpia la carpeta antes de build
        },
        server: {
            watch: {
                usePolling: true, // útil en contenedores Docker
            },
            hmr: {
                host: 'localhost', // cambiar según entorno de dev
            },
        },
    };
});
