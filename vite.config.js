import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { fileURLToPath, URL } from 'node:url';

export default defineConfig({
    plugins: [
        {
            name: 'resolve-public-assets',
            enforce: 'pre',
            resolveId(id) {
                // Intercept absolute paths to public/ assets so Rollup
                // emits a string literal instead of an import statement.
                if (id.startsWith('/image-') || id === '/ndauwologo.png' || id === '/favicon.ico' || id === '/vite.svg') {
                    return '\0virtual:public-asset:' + id;
                }
            },
            load(id) {
                if (id.startsWith('\0virtual:public-asset:')) {
                    const path = id.slice('\0virtual:public-asset:'.length);
                    return `export default ${JSON.stringify(path)};`;
                }
            },
        },
        laravel({
            input: ['resources/css/app.css', 'resources/js/main.js'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
