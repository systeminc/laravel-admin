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

'SLA' => SystemInc\LaravelAdmin\Facades\SLA::class,
```

## Configuration

Copy the package config to your local config with the publish command:

```php
php artisan vendor:publish --provider="SystemInc\LaravelAdmin\AdminServiceProvider"
```

## Setup

Just run below and we are set to go:

```php
php artisan laravel-admin:instal
```


## Contributing

Contributions to the Laravel Admin library are welcome. Please note the following guidelines before submiting your pull request.

- Follow [PSR-2](http://www.php-fig.org/psr/psr-2/) coding standards.
- Write tests for new functions and added features

## License

This Laravel Admin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)