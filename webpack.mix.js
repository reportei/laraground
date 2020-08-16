const mix = require('laravel-mix').setPublicPath('dist');
require("laravel-mix-tailwind");

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

mix
    .js('resources/tailwind/app.js', 'dist/tailwind.js')
    .sass('resources/tailwind/app.scss', 'dist/tailwind.css')
    .copy('node_modules/@fortawesome/fontawesome-free/js/all.js', 'dist/fontawesome.js')
    .tailwind("./tailwind.config.js")
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}
