# Laravel Administration Panel

[![Build Status](https://travis-ci.org/systeminc/laravel-admin.svg?branch=master)](https://travis-ci.org/systeminc/laravel-admin) [![StyleCI](https://styleci.io/repos/65193755/shield)](https://styleci.io/repos/65193755)

## Installation
------------

Install using composer:

```
composer require systeminc/laravel-admin
```

Add the service provider to the `'providers'` array in `config/app.php`:

```php
SystemInc\LaravelAdmin\AdminServiceProvider::class,
```

## Configuration

Copy the package config to your local config with the publish command:

```php
php artisan vendor:publish --provider="SystemInc\LaravelAdmin\AdminServiceProvider" --tag="laravel-admin"
```

Make sure that your add this in `'database/seeds/DatabaseSeeder.php'`

```php
public function run()
{
    $this->call(AdminSeeder::class);
}
```

and in `'gulpfile.js'`

```js
elixir(function(mix) {
    mix.less('login.less');
    mix.less('admin.less');

    mix.scripts(['jquery-1.12.4.js', 'jquery-ui.js','vue.js', 'tinymce/tinymce.min.js', 'tinymce-init.js', 'global.js','admin.js'], 'public/js/admin.js');    
	mix.scripts(['codemirror.js','php.js', 'xml.js','css.js', 'javascript.js', 'htmlmixed.js', 'clike.js', 'overlay.js'], 'public/js/editor.js');

    mix.copy('resources/assets/less/codemirror.css', 'public/css/codemirror.css');
    mix.copy('resources/assets/js/tinymce/skins', 'public/build/js/skins');
    mix.copy('resources/assets/js/ZeroClipboard.swf', 'public/build/js/ZeroClipboard.swf');

   	mix.version(['css/admin.css', 'css/login.css', 'css/codemirror.css', 'js/admin.js', 'js/editor.js']);
});
```

### Note

If your are using fresh install of Laravel 5.2 just push all our files in your app like so:

```php
php artisan vendor:publish --provider="SystemInc\LaravelAdmin\AdminServiceProvider" --tag="laravel-admin-force" --force
```

## Migrate

Just run below and we are set to go:

```php
php artisan migrate --seed
```

## Usage

To start using our admin panel go to your home url and add hit `'/administration'` in link:

```
'email' 	=> 'admin@system-inc.com',
'password'  => 'admin123'
```

Credentials for default login is in `'database/seeds/AdminSeeder.php'`. **Please change credentials if your are going outside you local environment.**

## Contributing

Contributions to the Laravel Admin library are welcome. Please note the following guidelines before submiting your pull request.

- Follow [PSR-2](http://www.php-fig.org/psr/psr-2/) coding standards.
- Write tests for new functions and added features

## License

This Laravel Admin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)