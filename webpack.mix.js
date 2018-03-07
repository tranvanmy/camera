let mix = require('laravel-mix');

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
    .js('resources/assets/admin/index.js', 'public/js/admin/index.js')
    .js('resources/assets/user/slider.js', 'public/js/user/slider.js')
    .sass('resources/assets/user/css/screen.scss', 'public/css/user/screen.css')

if (mix.inProduction()) {
    mix.version()
}
