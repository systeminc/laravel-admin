<?php

// LARAVEL ADMIN
Route::group(['middleware' => ['web'], 'prefix' => config('laravel-admin.route_prefix'), 'namespace' => 'SystemInc\LaravelAdmin\Http\Controllers'], function () {

    // resources
    Route::get('css/{filename}', 'ResourcesController@css');
    Route::get('scripts/{filename?}', 'ResourcesController@scripts')->where('filename', '(.*)');
    Route::get('images/{filename?}', 'ResourcesController@images')->where('filename', '(.*)');
    Route::get('uploads/{filename?}', 'UploadsController@index')->where('filename', '(.*)');

    // w/o credentials
    Route::get('login', 'AdminController@getLogin');
    Route::post('login', 'AdminController@postLogin');

    // with credentials
    Route::group(['middleware' => [SystemInc\LaravelAdmin\Http\Middleware\AuthenticateAdmin::class]], function () {

        // blog
        Route::group(['prefix' => 'blog', 'namespace' => 'Blog'], function () {

            // categories
            Route::group(['prefix' => 'categories'], function () {
                Route::post('save/{category_id}', 'CategoriesController@postSave');
                Route::get('delete/{category_id}', 'CategoriesController@getDelete');
                Route::get('edit/{category_id}', 'CategoriesController@getEdit');
                Route::get('new', 'CategoriesController@getNew');
                Route::get('', 'CategoriesController@getIndex');
            });

            Route::post('save/{post_id}', 'BlogController@postSave');
            Route::get('disapprove-comment/{comment_id}', 'BlogController@getDisapproveComment');
            Route::get('approve-comment/{comment_id}', 'BlogController@getApproveComment');
            Route::get('post-delete/{post_id}', 'BlogController@getPostDelete');
            Route::get('post-delete/{post_id}', 'BlogController@getPostDelete');
            Route::get('post-edit/{post_id}', 'BlogController@getPostEdit');
            Route::get('post-new', 'BlogController@getPostNew');
            Route::get('', 'BlogController@getIndex');
        });

        Route::group(['prefix' => 'shop', 'namespace' => 'Shop'], function () {

            // products
            Route::group(['prefix' => 'products'], function () {
                Route::post('save-variation/{product_id}', 'ProductsController@postSaveVariation');
                Route::post('update-variation/{variation_id}', 'ProductsController@postUpdateVariation');
                Route::get('delete-variation/{variation_id}', 'ProductsController@getDeleteVariation');
                Route::get('edit-variation/{variation_id}', 'ProductsController@getEditVariation');
                Route::get('add-variation/{product_id}', 'ProductsController@getAddVariation');
                Route::get('delete-similar/{similar_id}', 'ProductsController@getDeleteSimilar');
                Route::post('add-similar/{product_id}', 'ProductsController@postAddSimilar');
                Route::post('save/{product_id}', 'ProductsController@postSave');
                Route::get('delete/{product_id}', 'ProductsController@getDelete');
                Route::get('edit/{product_id}', 'ProductsController@getEdit');
                Route::get('new', 'ProductsController@getNew');
                Route::get('', 'ProductsController@getIndex');
            });

            // categories
            Route::group(['prefix' => 'categories'], function () {
                Route::post('save/{category_id}', 'CategoriesController@postSave');
                Route::get('delete/{category_id}', 'CategoriesController@getDelete');
                Route::get('edit/{category_id}', 'CategoriesController@getEdit');
                Route::get('new', 'CategoriesController@getNew');
                Route::get('', 'CategoriesController@getIndex');
            });

            // comments
            Route::group(['prefix' => 'comments'], function () {
                Route::get('disapprove/{comment_id}', 'CommentsController@getDisapprove');
                Route::get('approve/{comment_id}', 'CommentsController@getApprove');
                Route::get('', 'CommentsController@getIndex');
            });

            // orders
            Route::group(['prefix' => 'orders'], function () {
                Route::post('edit-item/{item_id}', 'OrdersController@postEditItem');
                Route::post('add-item/{item_id}', 'OrdersController@postAddItem');
                Route::post('save/{order_id}', 'OrdersController@postSave');
                Route::get('view-item/{item_id}', 'OrdersController@getViewItem');
                Route::get('print-invoice/{order_id}', 'OrdersController@getPrintInvoice');
                Route::get('send-invoice/{order_id}', 'OrdersController@getSendInvoice');
                Route::get('send-proforma/{order_id}', 'OrdersController@getSendProforma');
                Route::get('preview-invoice/{order_id}', 'OrdersController@getPreviewInvoice');
                Route::get('preview-proforma/{order_id}', 'OrdersController@getPreviewProforma');
                Route::get('delete-item/{item_id}', 'OrdersController@getDeleteItem');
                Route::get('edit/{order_id}', 'OrdersController@getEdit');
                Route::get('', 'OrdersController@getIndex');
            });

            // stock
            Route::group(['prefix' => 'stock'], function () {
                Route::get('', 'StockController@getIndex');
            });

            // shop
            Route::get('', 'ShopController@getIndex');
        });

        // galleries
        Route::group(['prefix' => 'galleries'], function () {
            Route::any('images/new-element/{image_id}', 'GalleriesController@getCreateElement');
            Route::post('images/add-element/{image_id}', 'GalleriesController@postCreateElement');
            Route::post('images/update-element/{element_id}', 'GalleriesController@postUpdateElement');
            Route::get('images/delete-element-file/{element_id}', 'GalleriesController@getDeleteElementFile');
            Route::get('images/edit-element/{element_id}', 'GalleriesController@getEditElement');
            Route::get('images/delete-element/{element_id}', 'GalleriesController@getDeleteElement');
            Route::post('save', 'GalleriesController@postSave');
            Route::post('update/{gallery_id}/{image_id?}', 'GalleriesController@postUpdate');
            Route::post('image/{gallery_id}/{image_id}', 'GalleriesController@postImageUpdate');
            Route::get('image/{gallery_id}/{image_id}', 'GalleriesController@getImage');
            Route::get('delete/{gallery_id}', 'GalleriesController@getDelete');
            Route::get('edit/{gallery_id}', 'GalleriesController@getEdit');
            Route::get('create', 'GalleriesController@getCreate');
            Route::get('', 'GalleriesController@getIndex');
        });

        //Places
        Route::group(['prefix' => 'places', 'namespace' => 'Places'], function () {
            // locations
            Route::group(['prefix' => 'locations'], function () {
                Route::get('delete/{location_id}', 'LocationsController@getDelete');
                Route::post('update/{location_id}', 'LocationsController@postUpdate');
                Route::get('edit/{location_id}', 'LocationsController@getEdit');
                Route::post('save', 'LocationsController@postSave');
                Route::get('create', 'LocationsController@getCreate');
                Route::get('', 'LocationsController@getIndex');
            });

            // locations
            Route::group(['prefix' => 'maps'], function () {
                Route::get('delete/{map_id}', 'MapsController@getDelete');
                Route::post('update/{map_id}', 'MapsController@postUpdate');
                Route::get('edit/{map_id}', 'MapsController@getEdit');
                Route::post('save', 'MapsController@postSave');
                Route::get('create', 'MapsController@getCreate');
                Route::get('', 'MapsController@getIndex');
            });

            Route::get('', 'PlacesController@getIndex');
        });

        // ajax
        Route::group(['prefix' => 'ajax'], function () {
            Route::post('{image_id}/change-gallery-image-element-order', 'AjaxController@postChangeGalleryImageElementOrder');
            Route::post('{page_id}/change-page-element-order', 'AjaxController@postChangePageElementOrder');
            Route::post('{page_id}/change-subpages-order', 'AjaxController@postChangeSubpagesOrder');
            Route::post('{type}/change-gallery-order', 'AjaxController@postChangeGalleryOrder');
            Route::post('{type}/delete-gallery-images/{id}', 'AjaxController@postDeleteGalleryImages');
            Route::post('change-product-categories-order', 'AjaxController@postChangeProductCategoryOrder');
            Route::post('change-product-order', 'AjaxController@postChangeProductOrder');
        });

        // leads
        Route::group(['prefix' => 'leads'], function () {
            Route::get('edit-email/{email_id}', 'LeadsController@getEditEmail');
            Route::post('email-leads', 'LeadsController@postEmail');
            Route::get('email-leads', 'LeadsController@getEmail');
            Route::post('settings', 'LeadsController@postSettings');
            Route::get('settings', 'LeadsController@getSettings');
            Route::get('delete/{lead_id}', 'LeadsController@getDelete');
            Route::get('edit/{lead_id}', 'LeadsController@getEdit');
            Route::get('', 'LeadsController@getIndex');
        });

        // pages
        Route::group(['prefix' => 'pages'], function () {
            Route::any('update-element/{page_id}', 'PagesController@postUpdateElement');
            Route::any('new-element/{page_id}', 'PagesController@postNewElement');
            Route::post('add-element/{page_id}', 'PagesController@postAddElement');
            Route::post('update/{page_id}', 'PagesController@postUpdate');
            Route::post('save', 'PagesController@postSave');
            Route::get('delete-element-file/{element_id}', 'PagesController@getDeleteElementFile');
            Route::get('delete-element/{element_id}', 'PagesController@getDeleteElement');
            Route::get('edit-element/{element_id}', 'PagesController@getEditElement');
            Route::get('delete/{page_id}', 'PagesController@getDelete');
            Route::get('edit/{page_id}', 'PagesController@getEdit');
            Route::get('create/{page_id}', 'PagesController@getCreate');
            Route::get('create', 'PagesController@getCreate');
            Route::get('', 'PagesController@getIndex');
        });

        // settings
        Route::group(['prefix' => 'settings'], function () {
            Route::post('create-admin', 'SettingsController@postCreateAdmin');
            Route::post('update-admin/{admin_id}', 'SettingsController@postUpdateAdmin');
            Route::post('change-password/{admin_id}', 'SettingsController@postChangePassword');
            Route::post('update', 'SettingsController@postUpdate');
            Route::get('edit/{admin_id}', 'SettingsController@getEdit');
            Route::get('add-admin', 'SettingsController@getAddAdmin');
            Route::get('', 'SettingsController@getIndex');
        });

        // admin
        Route::any('upload-tiny-image', 'AdminController@anyUploadTinyImage');
        Route::any('tiny-images', 'AdminController@anyTinyImages');
        Route::post('delete-tiny-image', 'AdminController@postDeleteTinyImage');
        Route::get('logout', 'AdminController@getLogout');
        Route::get('', 'AdminController@getIndex');
    });
});

Route::group(['middleware' => ['web'], 'prefix' => config('laravel-admin.route_prefix'), 'namespace' => 'App\Http\Controllers'], function () {
    Route::group(['middleware' => [SystemInc\LaravelAdmin\Http\Middleware\AuthenticateAdmin::class]], function () {
        if (File::exists('../routes/sla-routes.php')) {
            require app_path('../routes/sla-routes.php');
        }
    });
});
