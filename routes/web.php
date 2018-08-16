<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$vue_routers = [
    '/products/{id?}/edit', '/baskets/{id?}/edit',
    '/products', '/baskets', '/baskets/create', '/products/create',
];

foreach ($vue_routers as $path) {
    Route::get($path, function () {
        return view('index');
    });
}

