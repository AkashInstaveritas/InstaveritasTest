<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'API\Auth\LoginController@login')->name('login');
Route::get('/logout', 'API\Auth\LoginController@logout')->middleware('auth:api');

/**
 * API Routes for all and single category.
 **/
Route::get('/categories', 'API\CategoryController@index')->name('categories');
Route::get('/category/{id}', 'API\CategoryController@show');

/**
 * API Route for single subcategory and its relation.
 **/
Route::get('/subcategory/{id}', 'API\SubCategoryController@show');


/**
 * API Route for products, its details and CRUD Operations.
 **/
Route::get('/products/all', 'API\ProductController@index');
Route::get('/product/{id}', 'API\ProductController@show');

/**
 * API Route for users wishlist, its details and CRUD Operations.
 **/
Route::post('/wishlist/products', 'API\WishListController@store')->middleware('auth:api');
Route::get('/wishlist', 'API\WishListController@show')->middleware('auth:api');
