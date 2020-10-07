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
        Route::get('/', 'HomeController@home')->name('home');
        Route::get('products', 'HomeController@home')->name('product');
        Route::get('about', 'HomeController@home')->name('about');
        Route::get('contact', 'HomeController@home')->name('contact');
        Route::get('cart', 'HomeController@home')->name('cart');
    });
    Route::group(['prefix' => 'admin'], function() {
        Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
        Route::resource('products', 'Admin\ProductController')->names('products');
    });
});
