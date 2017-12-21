const { mix } = require('laravel-mix');

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
mix.setPublicPath('resources/assets/dist/');

mix.autoload({
   jquery: [ '$', 'window.jQuery', 'jQuery']
});

mix.copyDirectory('resources/assets/src/bower_components/tinymce/plugins', 'resources/assets/dist/js/plugins');
mix.copyDirectory('resources/assets/src/bower_components/tinymce/skins', 'resources/assets/dist/js/skins');
mix.copyDirectory('resources/assets/src/bower_components/tinymce/themes', 'resources/assets/dist/js/themes');
mix.copyDirectory('resources/assets/src/images', 'resources/assets/dist/images');

mix.less('resources/assets/src/less/admin.less', '../dist/css/admin.css')
    .less('resources/assets/src/less/login.less', '../dist/css/login.css')
    .options({
        processCssUrls: false
    });

mix.scripts(['resources/assets/src/bower_components/jquery/dist/jquery.js',
    'resources/assets/src/bower_components/jquery-ui/jquery-ui.js',
    'resources/assets/src/js/admin.js',
    'resources/assets/src/bower_components/tinymce/tinymce.js',
    'resources/assets/src/js/tinymce-init.js',
    'resources/assets/src/js/global.js',
    'resources/assets/src/js/timepicker.js'
], 'resources/assets/dist/js/admin.js');
