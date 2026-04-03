import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    base: '/proppikclient/',
    plugins: [
        laravel({
            input: [
                // app css file is where we import all our css files, so we only need to specify this one file here
                'resources/css/app.css',
                
                // app js file is where we import all our js files, so we only need to specify this one file here
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
