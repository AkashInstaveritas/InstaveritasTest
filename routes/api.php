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

Route::group(['namespace' => 'API'], function(){

    /**
     * API Routes for authentication of user.
     **/
    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::get('/logout', 'Auth\LoginController@logout')->middleware('auth:api');


    /**
     * API Routes for all and single category.
     **/
    Route::get('/categories', 'CategoryController@index');
    Route::get('/category/{id}', 'CategoryController@show');

    /**
     * API Route for single subcategory and its relation.
     **/
    Route::get('/subcategory/{id}', 'SubCategoryController@show');


    /**
     * API Route for products, its details and CRUD Operations.
     **/
    Route::get('/products/all', 'ProductController@index');
    Route::get('/product/{id}', 'ProductController@show');
});


Route::group(['middleware' => 'auth:api', 'namespace' => 'API'], function(){
   
    /**
     * API Route for users wishlist, its details and CRUD Operations.
     **/
    Route::post('/wishlist/products', 'WishListController@store');
    Route::get('/wishlist', 'WishListController@show');
    Route::delete('/wishlist/product/{id}', 'WishListController@destroy');

    /**
     * API Route for users cart, its details and CRUD Operations.
     **/
    Route::post('/cart/products', 'CartController@store');
    Route::get('/cart', 'CartController@show');
    Route::post('/cart/product/update/{id}', 'CartController@update');
    Route::delete('/cart/product/{id}', 'CartController@destroy');

    /**
     * API Route for users addresses, its details and CRUD Operations.
     **/
    Route::get('/addresses', 'AddressController@index');
    Route::post('/user/address', 'AddressController@store');
    Route::get('/address/{id}', 'AddressController@show');
    Route::patch('/address/{id}', 'AddressController@update');
    Route::delete('/address/{id}', 'AddressController@destroy');
});
