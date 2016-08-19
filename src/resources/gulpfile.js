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
    mix.copy('resources/assets/js/tinymce/skins', 'public/build/js/skins');

    mix.less(['resources/assets/less/codemirror.css', 'login.less', 'admin.less'],'public/css/admin.css');

    mix.scripts(['codemirror.js','php.js', 'xml.js', 'vue.js', 'css.js', 'javascript.js', 'htmlmixed.js', 'clike.js', 'overlay.js', 'jquery-1.12.4.js', 'jquery-ui.js', 'tinymce/tinymce.min.js', 'tinymce-init.js', 'global.js','admin.js'], 'public/js/admin.js');
});
