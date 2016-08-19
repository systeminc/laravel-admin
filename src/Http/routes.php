<?php

// LARAVEL ADMIN
Route::group(['middleware' => ['web'], 'prefix' => 'administration', 'namespace' => 'SystemInc\LaravelAdmin\Http\Controllers'], function () {

    // resources
    Route::get('css/{filename}', 'ResourcesController@css');
    Route::get('scripts/{filename?}', 'ResourcesController@scripts')->where('filename', '(.*)');
    Route::get('images/{filename}', 'ResourcesController@images');
    Route::controller('uploads', 'UploadsController');

    // w/o credentials
    Route::get('login', 'AdminController@getLogin');
    Route::post('login', 'AdminController@postLogin');

    // with credentials
    Route::group(['middleware' => [SystemInc\LaravelAdmin\Http\Middleware\AuthenticateAdmin::class]], function () {

        Route::group(['prefix' => 'blog', 'namespace' => 'Blog'], function () {
            Route::controller('comments', 'CommentsController');
            Route::controller('', 'BlogController');
        });

        Route::group(['prefix' => 'shop', 'namespace' => 'Shop'], function () {
            Route::controller('products', 'ProductsController');
            Route::controller('categories', 'CategoriesController');
            Route::controller('comments', 'CommentsController');
            Route::controller('orders', 'OrdersController');
            Route::controller('stock', 'StockController');
            Route::controller('', 'ShopController');
        });

        Route::controller('pages', 'PagesController');
        Route::controller('galleries', 'GalleriesController');
        Route::controller('ajax/{type}', 'AjaxController');
        Route::controller('code-blocks', 'CodeBlocksController');
        Route::controller('', 'AdminController');
    });
});
