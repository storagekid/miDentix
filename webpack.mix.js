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
 mix.options({
   extractVueStyles: false
 });

mix.js(['resources/assets/js/app.js', 'resources/assets/js/tools/functions.js'], 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/excel-tables.scss', 'public/css')
mix.scripts('resources/assets/js/tools/functions.js', 'public/js/functions.js');
