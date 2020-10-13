<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'localization'], function() {
    Route::get('lang/{language}', 'LocalizationController@changeLanguage')->name('localization');
    Route::name('user.')->group(function() {
        Route::get('login', 'LoginController@getLogin')->name('getLogin');
        Route::post('login', 'LoginController@postLogin')->name('postLogin');
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::get('register', 'RegisterController@getRegister')->name('getRegister');
        Route::post('register', 'RegisterController@postRegister')->name('postRegister');
        Route::get('/', 'HomeController@home')->name('home');
        Route::get('product', 'ProductController@index')->name('product');
        Route::get('product/{id}', 'ProductController@show')->name('product.show');
        Route::get('about', 'HomeController@home')->name('about');
        Route::get('contact', 'HomeController@home')->name('contact');
        Route::get('cart', 'HomeController@home')->name('cart');
        Route::get('quantity/{id}', 'ProductController@quantity')->name('quantity');
    });
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
        Route::get('/', 'DashboardController@index')->name('admin.dashboard');
        Route::group(['prefix' => 'manage-product'], function () {
            Route::resource('products', 'ProductController')->names('products');
            Route::delete('delete-image/{id}', 'ProductController@deleteImage')->name('delete.image');
            Route::delete('delete-comment/{id}', 'ProductController@deleteComment')->name('delete.comment');
            Route::delete('delete-productDetail/{id}', 'ProductController@deleteProductDetail')->name('delete.productDetail');
        });
        Route::group(['prefix' => 'manage-order'], function () {
            Route::resource('orders', 'OrderController')->names('orders');
            Route::patch('order/{id}/approved', 'OrderController@approvedOrder')->name('orders.approved');
            Route::patch('order/{id}/rejected', 'OrderController@rejectedOrder')->name('orders.rejected');
        });
        Route::group(['prefix' => 'manage-supplier'], function () {
           Route::resource('suppliers', 'SupplierController')->names('suppliers');
        });
    });
});
