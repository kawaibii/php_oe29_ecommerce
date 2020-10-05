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
    Route::get('/', 'HomeController@home')->name('home');
    Route::group(['prefix' => 'admin'], function() {
        Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
    });
});
