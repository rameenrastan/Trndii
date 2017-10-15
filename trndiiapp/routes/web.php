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

Route::resource('preregisteredusers', 'PreregisteredUsersController');
