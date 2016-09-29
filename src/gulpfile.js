var elixir = require('laravel-elixir');

elixir.config.assetsPath = 'resources/assets/src/';
elixir.config.publicPath = '';
elixir.config.js.folder = '';
elixir.config.production = true;

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

    mix.copy('resources/assets/src/bower_components/tinymce/plugins', 'resources/assets/dist/js/plugins');
    mix.copy('resources/assets/src/bower_components/tinymce/skins', 'resources/assets/dist/js/skins');
    mix.copy('resources/assets/src/bower_components/tinymce/themes', 'resources/assets/dist/js/themes');
    mix.copy('resources/assets/src/bower_components/jquery-ui/images', 'resources/assets/dist/images/datepicker');

    mix.less(
    	[
	    	'login.less', 
            '../bower_components/jquery-ui/themes/base/jquery-ui.css',
            'admin.less'
    	],
    	'resources/assets/dist/css/admin.css'
    );

    mix.scripts(
	    [
	    	'bower_components/jquery/dist/jquery.js',
	    	'bower_components/jquery-ui/jquery-ui.js',
	    	'bower_components/tinymce/tinymce.js',
	    	'js/tinymce-init.js',
	    	'js/global.js',
	    	'js/admin.js'
    	],
    	'resources/assets/dist/js/admin.js'
    );

});
