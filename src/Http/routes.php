<?php

//ADMIN
Route::group(['middleware' => ['web'], 'prefix' => 'administration', 'namespace' => 'SystemInc\LaravelAdmin\Http\Controllers\Admin'], function () {

    // actions w/o credentials
    Route::get('login', 'AdminController@getLogin');
    Route::post('login', 'AdminController@postLogin');

    // actions with credentials
    Route::group(['middleware' => [SystemInc\LaravelAdmin\Http\Middleware\AuthenticateAdmin::class]], function () {
        Route::controller('pages', 'PagesController');
        Route::controller('', 'AdminController');
    });
});
