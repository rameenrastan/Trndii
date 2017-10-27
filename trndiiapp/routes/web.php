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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/payment', 'PaymentsController@updateCard');

Route::get('/editDetails', 'UsersController@edit')->middleware('authenticated');

Route::get('/editAccount', 'EditAccountController@index')->middleware('authenticated');

Route::resource('users', 'UsersController');

Route::get('/preregistration', 'ViewsController@preregistration');

Route::get('/successpreregistration', 'ViewsController@successpreregistration');

Route::get('/purchaseHistory', 'PurchasedItemsController@index');

Route::resource('preregisteredusers', 'PreregisteredUsersController');
    Route::prefix('admin')->group(function() {
        Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
        Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
        Route::get('/', 'AdminController@index')->name('admin.home');
   });

//Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
//Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
//Route::get('/admin', 'AdminController@index')->name('admin.home');
    
Route::resource('item', 'ItemsController');

Route::resource('purchaseditems', 'PurchasedItemsController');