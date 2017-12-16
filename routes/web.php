<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get( '/', function () {
	return response()->redirectToRoute( 'login' );
} );

Route::get( 'refer/{guid}', 'Auth\RegisterController@referral' )->name( 'register.referral' );

//Deactivated Controllers
Route::get( 'activate', 'ActivateController@index' )->name( 'activate.index' );
Route::get( 'activate/send', 'ActivateController@send' )->name( 'activate.send' );
Route::get( 'activate/{token}', 'ActivateController@activation' )->name( 'activate.activation' );

// Dashboard
Route::get( '/dashboard', 'DashboardController@index' )->name('dashboard');

// User
Route::get( 'user/data', 'UserController@data' )->name( 'user.data' );
Route::get( 'user/deposit', 'UserController@deposit' )->name( 'user.deposit.view' );
Route::post( 'user/deposit', 'UserController@deposit' )->name( 'user.deposit' );
Route::resource( 'user', 'UserController' );

// Token
Route::get( 'ico', 'TokenController@purchase' )->name( 'token.index' );
Route::post( 'ico', 'TokenController@purchase' )->name( 'token.purchase' );

// Wallet
Route::get( 'wallet', 'WalletController@index' )->name( 'wallet.index' );
Route::get( 'wallet/transactions', 'TransactionController@index' )->name( 'wallet.transactions' );
Route::get( 'wallet/transactions/data', 'TransactionController@data' )->name( 'wallet.transactions.data' );
Route::get( 'wallet/transactions/{transaction}', 'TransactionController@show' )->name( 'wallet.transactions.show' );
Route::get( 'wallet/transactions/request/{transaction}', 'AdminController@show_transaction_request' )->name( 'wallet.transactions.show_request' );
Route::post( 'wallet/transactions/response/{transaction}', 'AdminController@response_transaction_request' )->name( 'wallet.transactions.request_response' );
Route::post( 'wallet/withdraw', 'WalletController@withdraw' )->name( 'wallet.withdraw' );

// Pusher
Route::get( 'pusher/auth', 'PusherController@auth' )->name( 'pusher.auth' );