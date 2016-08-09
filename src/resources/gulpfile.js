var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('login.less');
    mix.less('admin.less');

    mix.scripts(['jquery-1.12.4.js', 'jquery-ui.js','vue.js', 'tinymce/tinymce.min.js', 'tinymce-init.js', 'global.js','admin.js'], 'public/js/admin.js');

   	mix.version(['css/admin.css', 'css/login.css', 'js/admin.js']);
});
