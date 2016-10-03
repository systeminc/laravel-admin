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

STILL TODO

#BLOG

Get posts

`SLA::blog()->posts->get()`


Get blog categories

`SLA::blog()->categories->get()`


Get comments

`SLA::blog()->comments->get()`

# Files

All our files are stored at `storage/app` and saved in our database by `storage_key` so we need to provide you URL to file. It is tested for Local storage, but feel free to send a review on another storage driver.

`SLA::getFile($filename)`

# Page

All page

`SLA::page()->get()`

All elements

`SLA::page()->elements->get()`

Single element

`SLA::element($element_key)`

Array page manu

`SLA::page()->tree()`

Nested page menu (HTML output)

`SLA::page()->menu()`

# Gallery

All gallery

`SLA::gallery()->get()`

Single gallery

`SLA::gallery($gallery_key)`

Available methods:

  `images` - Collection of images
  
  `url` - All our images and files are stored in `storage/app` path so we need to generate URL from `storage_key`. Only tested with the local filesystem (`Storage`) so feel free to send a review for `s3` or any other.
  
```php
foreach(SLA::gallery('foo')->images as $image) {
  echo '<img src="$image->url">';
}
```

# Lead

Subscribe your user and send welcome email
Your can find settings for `lead` in our admin panel under menu `Leads`

`SLA::lead()->subscribe($request->all())` Params `Illuminate\Http\Request $request`

Unsubscribe

`SLA::lead()->unsubscribe($columb, $value)` etc. `SLA::lead()->unsubscribe('email', JohnDoe@example.com)`

# Location 

All location

`SLA::locations()`

Single location

`SLA::location($location_key)`

All maps

`SLA::maps()`

Single map

`SLA::map($map_key)`

# Shop

All products

`SLA::shop()->product()->get()`

All categories

`SLA::shop()->categories()->get()`

All comments

`SLA::shop()->comments()->get()`

All Orders

`SLA::shop()->orders()->get()`

## Contributing

Contributions to the Laravel Admin library are welcome. Please note the following guidelines before submiting your pull request.

- Follow [PSR-2](http://www.php-fig.org/psr/psr-2/) coding standards.
- Write tests for new functions and added features

## License

This Laravel Admin is open-source software licensed under the [MIT license](http://opensource.org/licenses/MIT)
