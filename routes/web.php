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
        Route::get('api/business-partners', 'BusinessPartnerMasterController@apiBusinessPartners');
    });

    Route::group(['namespace' => 'Sales', 'prefix' => 'sales'], function () {
        Route::resource('sales-quotation', 'SalesQuotationController');
        Route::resource('sales-order', 'SalesOrderController');
        Route::resource('delivery', 'DeliveryController');
        Route::resource('sales-invoice', 'SalesInvoiceController');
    });

    Route::group(['namespace' => 'Purchasing', 'prefix' => 'purchasing'], function () {
        Route::resource('purchases-request', 'PurchasesRequestController');
        // Route::resource('purchases-quotation', 'PurchasesQuotationController');
        Route::resource('purchases-order', 'PurchasesOrderController');
        Route::resource('goods-receipt-po', 'GoodsReceiptPOController');
        Route::resource('purchases-invoice', 'PurchasesInvoiceController');
    });

    Route::group(['namespace' => 'Inventory', 'prefix' => 'inventory'], function () {
        Route::resource('item-master-data', 'ItemMasterDataController');

        Route::group(['namespace' => 'Transaction', 'prefix' => 'transaction'], function () {
            Route::resource('goods-receipt', 'GoodsReceiptController');
            Route::resource('goods-issue', 'GoodsIssueController');
        });
    });

    Route::group(['namespace' => 'Production', 'prefix' => 'production'], function () {
        Route::resource('bill-of-material', 'BillOfMaterialController');
        Route::resource('production-order', 'ProductionOrderController');
    });

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    Route::get('/about', function () {
        return view('about');
    })->name('about');
});
