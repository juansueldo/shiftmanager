import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
      buildDirectory: 'build', // esto asegura que Laravel busque en public/build
    }),
    tailwindcss(),
  ],
  build: {
    outDir: 'public/build',
    emptyOutDir: true,
    manifest: true,
  },
});
