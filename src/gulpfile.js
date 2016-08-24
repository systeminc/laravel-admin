var elixir = require('laravel-elixir');

elixir.config.assetsPath = 'resources/assets/src/';

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

    mix.copy('resources/assets/src/js/tinymce/plugins', 'resources/assets/dist/js/plugins');
    mix.copy('resources/assets/src/js/tinymce/skins', 'resources/assets/dist/js/skins');
    mix.copy('resources/assets/src/js/tinymce/themes', 'resources/assets/dist/js/themes');

    mix.less(
    	[
	    	'codemirror.css', 
	    	'login.less', 
	    	'admin.less'
    	],
    	'resources/assets/dist/css/admin.css'
    );

    mix.scripts(
	    [
	    	'codemirror.js',
	    	'php.js',
	    	'xml.js',
	    	'vue.js',
	    	'css.js',
	    	'javascript.js',
	    	'htmlmixed.js',
	    	'clike.js',
	    	'overlay.js',
	    	'jquery-1.12.4.js',
	    	'jquery-ui.js',
	    	'tinymce/jquery.tinymce.min.js',
	    	'tinymce/tinymce.min.js',
	    	'tinymce-init.js',
	    	'global.js',
	    	'admin.js'
    	],
    	'resources/assets/dist/js/admin.js'
    );

});
