# Laravel Administration Panel

[![Build Status](https://travis-ci.org/systeminc/laravel-admin.svg?branch=master)](https://travis-ci.org/systeminc/laravel-admin) [![StyleCI](https://styleci.io/repos/65193755/shield)](https://styleci.io/repos/65193755)

This is **Laravel Admin**, CRUD (create, read, update and delete) package that can help you get your administration panel in minutes. At this moment we support these modules:

- **Pages** (page elements, galleries, subpages)
- **Blog** (posts, comments)
- **Shop** (products, categories, comments, orders, stock)

Once you have your administration panel up, you can easily put all of those elements wherever you want in you application files. For usage documentation see **Usage section** bellow.

---

## Installation

Install using composer:

```
composer require systeminc/laravel-admin
```

Add the service provider to the `'providers'` array in `config/app.php`:

```php
SystemInc\LaravelAdmin\AdminServiceProvider::class,
```

If you want to use this package as a facade, add this line to the `$aliases` array in `config/app.php`.

```php
'SLA' => SystemInc\LaravelAdmin\Facades\SLA::class,
```

Start package installation by running instal command below:

```php
php artisan laravel-admin:instal
```

If our package update throws composer, please update dependency running commend below:

```php
php artisan laravel-admin:update
```

Note that this installation uses migrations, so you must run it from machine that has access to your database. 

For instance, if you use Vagrant, you will have to do `vagrant ssh` first, go to your project directory, and run this instal command. The same way you run your standard Laravel's migration command. 

## Usage

Visit [wiki](https://github.com/systeminc/laravel-admin/wiki/Blog) for more 

## Contributing

Contributions to the Laravel Admin library are welcome. Please note the following guidelines before submiting your pull request.

- Follow [PSR-2](http://www.php-fig.org/psr/psr-2/) coding standards.
- Write tests for new functions and added features

## License

This Laravel Admin is open-source software licensed under the [MIT license](http://opensource.org/licenses/MIT)
