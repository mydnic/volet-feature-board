import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        vue(),
    ],
    build: {
        outDir: 'resources/dist',
        rollupOptions: {
            input: {
                'volet-feature-board-app': resolve(__dirname, 'resources/js/volet-feature-board.js'),
                'volet-feature-board-style': resolve(__dirname, 'resources/css/volet-feature-board.css')
            },
            output: {
                entryFileNames: '[name].js',
                assetFileNames: '[name][extname]'
            }
        }
    }
});
