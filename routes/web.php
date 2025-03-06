<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth', 'sap.session'], 'prefix' => 'sap'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['namespace' => 'BusinessPartners', 'prefix' => 'business-partner'], function () {
        Route::resource('business-master', 'BusinessPartnerMasterController');
    });

    Route::group(['namespace' => 'Sales', 'prefix' => 'sales'], function () {
        Route::resource('sales-quotation', 'SalesQuotationController');
        Route::resource('sales-order', 'SalesOrderController');
        Route::resource('delivery', 'DeliveryController');
        Route::resource('invoice', 'InvoiceController');
    });

    Route::group(['prefix' => 'purchasing'], function () {
        //
    });

    Route::group(['prefix' => 'inventory'], function () {
        //
    });

    Route::group(['prefix' => 'production'], function () {
        //
    });

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    Route::get('/about', function () {
        return view('about');
    })->name('about');
});
