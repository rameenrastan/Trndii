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

use Gloudemans\Shoppingcart\Facades\Cart;

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/payment', 'PaymentsController@updateCard');

Route::get('/editDetails', 'UsersController@edit')->middleware('authenticated');

Route::resource('users', 'UsersController');

Route::get('/preregistration', 'PreregisteredUsersController@index');

Route::get('/successpreregistration', 'ViewsController@successpreregistration');

Route::get('/purchaseHistory', 'TransactionsController@index');

Route::get('/viewProgress', 'TransactionsController@index');

Route::get('/supplier/items', 'SupplierController@viewItemsStatus');

Route::get('/supplier/create', 'AdminController@createSupplier');
Route::post('/supplier/store', 'AdminController@storeSupplier');

Route::get('/banUserForm', 'AdminController@banUserForm');
Route::post('/banUserForm', 'AdminController@banUser');

Route::prefix('supplier')->group(function(){
    Route::get('/login', 'Auth\SupplierLoginController@showLoginForm')->name('supplier.login');
    Route::post('/login', 'Auth\SupplierLoginController@login')->name('supplier.login.submit');
    Route::get('/', 'SupplierController@index')->name('supplier.home');
    Route::get('/reviews', 'SupplierController@viewReviews');
});

Route::resource('preregisteredusers', 'PreregisteredUsersController');
    Route::prefix('admin')->group(function() {
        Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
        Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
        Route::get('/', 'AdminController@index')->name('admin.home');
   });
    
Route::resource('item', 'ItemsController');

Route::get('item.create', 'ItemsController@item.create');

Route::post('item.store','ItemsController@store');

Route::get('/confirm/{id}', 'ItemsController@getConfirm');

Route::resource('transactions', 'TransactionsController');

//Route::get('tokensUpdate', 'TransactionsController@updateTokens'); //
Route::put('updateTokens/{id}','TransactionsController@createTransaction');

Route::post('/send', 'EmailController@send');

Route::get('contact', 'PagesController@getContact');

Route::post('contact', 'PagesController@postContact');

Route::get('/viewAllItems', 'ItemsController@viewAllItems');

Route::get('/addresses', 'ExportController@makePDF');

Route::get('/browseItemsByCategory', 'ItemsController@getItemsByCategory');


Route::get('/faq', 'PagesController@getFAQ');

Route::get('/aboutUs', 'PagesController@getAboutUs');

Route::post('/search', 'ItemsController@search');

Route::get('/search', 'ItemsController@search');

Route::get('/shoppingCart', 'CartController@index');


Route::post('/shoppingCart', 'CartController@store')->name('cart.store');


Route::post('/addcomment/{itemid}/{page}', ['uses' => 'ItemsController@addComment', 'as' => 'ItemController.addComment']);


Route::delete('/shoppingCart/{id}', 'CartController@destroy')->name('cart.destroy');

Route::post('/purchaseHistory', 'ReviewController@store')->name('review.store');

Route::post('/item', 'ReviewController@storeLikeDislike')->name('review.storeLikeDislike');

Route::get('/getMetrics', 'ExportController@getExcelMetrics')->middleware('auth:admin');

$router->get('/pdfInfo/{itemId}/{itemName}',[
    'uses' => 'ExportController@getPdfByItem',
    'as'   => 'PdfController'
]);

$router->get('/excelInfo/{itemId}/{itemName}',[
    -    'uses' => 'ExportController@getExcelByItem',
    -    'as'   => 'ExcelController'
        -]);

$router->get('/itemThread/{itemId}',[
    'uses' => 'ItemsController@getItemThread',
    'as'   => 'ItemController'
]);
$router->get('/showItem/{itemId}',[
    'uses' => 'ItemsController@show',
    'as'   => 'showItem'
]);

Route::get('emptyCart', function() { //temporary function to empty the shopping cart.
    Cart::destroy();
});
