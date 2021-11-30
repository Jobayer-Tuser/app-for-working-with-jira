const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.options({
    processCssUrls: false
});

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

mix.sass('resources/sass/assets/structure.scss', 'public/assets/css/')
    .sass('resources/sass/assets/loader.scss', 'public/assets/css/')
    .sass('resources/sass/assets/main.scss', 'public/assets/css/')
    .sass('resources/sass/assets/scrollspyNav.scss', 'public/assets/css/')
