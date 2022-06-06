const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.setResourceRoot('../');

mix.js('resources/js/app.js', 'public/js', 'resources/js/main.js', 'resources/js/modal.js')
    .css('resources/css/room.css', 'public/css')
    .sass('resources/sass/app.scss', 'public/css')
    .version()
    .sourceMaps();
