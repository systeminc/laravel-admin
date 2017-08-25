 # Laravel Administration Panel

[![Build Status](https://travis-ci.org/systeminc/laravel-admin.svg?branch=master)](https://travis-ci.org/systeminc/laravel-admin) [![StyleCI](https://styleci.io/repos/65193755/shield)](https://styleci.io/repos/65193755)

This is **Laravel Admin**, CRUD (create, read, update and delete) package that can help you get your administration panel in minutes. At this moment we support these modules:

- **Pages** (page elements, subpages, images, html editor)
- **Galleries** (images, change order)
- **Blog** (posts, comments)
- **Shop** (products, categories, comments, orders, stock)
- **Places** (locations, maps)
- **Leads** (contacts, subscriptions)
- **Multiple admins**

Once you have your administration panel up, you can easily put all of those elements wherever you want in you application files. For usage documentation see **Usage section** bellow.

Supports Laravel 5.2. -> 5.4.

<img src="/screens/1.png?raw=true" width="250"> . . . <img src="/screens/2.png?raw=true" width="250"> . . . <img src="/screens/3.png?raw=true" width="250"> 

---

## Installation

Install using composer:

```
$ composer require systeminc/laravel-admin
```

For Laravel 5.5 support Auto Discovery Packages.

Add the service provider to the `'providers'` array in `config/app.php` for Laravel 5.4 and lower:

```php
SystemInc\LaravelAdmin\AdminServiceProvider::class,
```

If you want to use this package as a facade, add this line to the `$aliases` array in `config/app.php`.

```php
'SLA' => SystemInc\LaravelAdmin\Facades\SLA::class,
```

Start package installation by running instal command below:

```
$ php artisan laravel-admin:instal
```
If you want to instal package again from scratch, just delete the `config/laravel-admin.php` file and drop database, then run install command again.

If our package update throws composer error, try updating dependencies manually with commend below:

```
$ php artisan laravel-admin:update
```

Note that this installation uses migrations, so you must run it from machine that has access to your database. 

For instance, if you use Vagrant, you will have to do `vagrant ssh` first, go to your project directory, and run this instal command. The same way you run your standard Laravel's migration command. 


## Extends

- To extend `order item` view in admin panel, in order to customize and show more details about your `order item` that are custom to your bisnis model, add blade template `resources\view\sla\order\item.blade.php` in you project. `order item` data is available within `$orderItem` variable.
- To extend admin package navigations view add blade in you project `resources\view\sla\layout\navigation.blade.php`. Use unordered list `<ul>`.
- To extend admin router with your own controllers create new file in `/routes/sla-routes.php` and point it to you controller. This will be under choosen `prefix` and secured with Admin's credentials. To keep `view` in same layout visit this [example](https://github.com/systeminc/laravel-admin/wiki/Extended-view) 



## Image cache 

If you use Laravel Admin v1.4 or greater, please run this command on you project that you working with. This will link `public` directory to `storage/app/public` in order for cache images to work.

```
$ php artisan storage:link
```

If you already have files in `storage/app` from older version of Laravel Admin, please move it manualy to the `storage/app/public` directory.

## Database export

If you use this Laravel Admin package within a team, you will find this artisan command that backups and restores database very useful.

Backup database with command:

```
$ php artisan laravel-admin:dump-database
```

Your will be prompted to `Enter password:` for mysql user specified in `.env`. File will be saved in `/database/sla_dumps`.

To restore database on another mashine use:

```
$ php artisan laravel-admin:restore-database
```

**WARNING** that this will be **DROP** table and restore latest migration in `database/sla_dumps` folder.
Your will be prompted to proceed twice with droping database. Mysql will ask several times to `Enter password:` for mysql user specified in `.env`. 
**We are not responsible for any data loss. Use this with caution.**

## Usage

Visit [wiki](https://github.com/systeminc/laravel-admin/wiki/Blog) 

## Contributing

Contributions to the Laravel Admin library are welcome. Please note the following guidelines before submiting your pull request.

- Follow [PSR-2](http://www.php-fig.org/psr/psr-2/) coding standards.
- Write tests for new functions and added features
- use development branch
- use `gulp --production` for assets


composer install
```
$ composer install
```

npm install
```
$ npm --prefix ./src install
```

bower install
```
$ cd src/resources/assets/src
$ bower install
```

build
```
$ cd src
$ npm run production
```

## License

This Laravel Admin is open-source software licensed under the [MIT license](http://opensource.org/licenses/MIT)
