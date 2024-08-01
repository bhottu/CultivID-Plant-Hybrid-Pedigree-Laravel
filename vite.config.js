import { defineConfig } from 'vite';
import WindiCSS from 'vite-plugin-windicss';
const laravel = require('laravel-vite-plugin').default;

export default defineConfig({
    plugins: [
        laravel(),
        WindiCSS(),
    ],
});
