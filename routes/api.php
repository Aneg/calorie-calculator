<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth', 'Api\AuthController@auth')->name('api.auth');

Route::group(['middleware' => ['auth:api']], function (){

    /* TOKEN */

    Route::get('check-token', 'Api\AuthController@checkToken')
        ->name('api.check_token');

    /* USERS */

    Route::get('users/{userId?}', 'Api\UsersController@show')
        ->where('userId', '\d+')
        ->name('api.users.show');
    Route::post('users', 'Api\UsersController@store')
        ->name('api.users.store');


    /* PRODUCTS */

    Route::post('products', 'Api\ProductController@store')
        ->name('api.product.store');
    Route::get('products/{productId?}', 'Api\ProductController@show')
        ->where('productId', '\d+')
        ->name('api.products.show');
    Route::put('products/{productId}', 'Api\ProductController@update')
        ->where('productId', '\d+')
        ->name('api.products.update');
    Route::delete('products/{productId}', 'Api\ProductController@destroy')
        ->where('productId', '\d+')
        ->name('api.products.destroy');

    /* BASKETS */

    Route::post('baskets', 'Api\BasketsController@store')
        ->name('api.baskets.store');
    Route::put('baskets/{basketId}', 'Api\BasketsController@update')
        ->where('basketId', '\d+')
        ->name('api.baskets.update');
    Route::get('baskets/{basketId?}', 'Api\BasketsController@show')
        ->where('basketId', '\d+')
        ->name('api.baskets.show');
    Route::delete('baskets/{basketId}', 'Api\BasketsController@destroy')
        ->where('productId', '\d+')
        ->name('api.baskets.destroy');
});
