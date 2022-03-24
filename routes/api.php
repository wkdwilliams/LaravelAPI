<?php

use Illuminate\Support\Facades\Route;

Route::post('auth/login'  , '\Core\Controllers\AuthController@login');
Route::post('auth/logout' , '\Core\Controllers\AuthController@logout');

// Test authentication
Route::group(['middleware' => ['auth']], function(){

    // Products
    Route::resource('/product', '\App\Product\Controllers\ProductController');

});

// Categories
Route::resource('/category', '\App\category\Controllers\categoryController');
Route::get('/category/name/{name}' , '\App\category\Controllers\categoryController@getResourceByName');