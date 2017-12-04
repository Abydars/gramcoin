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

//Deactivated Controllers
Route::get( 'activate', 'ActivateController@index' )->name( 'activate.index' );
Route::get( 'activate/send', 'ActivateController@send' )->name( 'activate.send' );
Route::get( 'activate/{token}', 'ActivateController@activation' )->name( 'activate.activation' );

// Dashboard
Route::get( '/dashboard', 'DashboardController@index' );

// User
Route::get( 'user/data', 'UserController@data' )->name( 'user.data' );
Route::get( 'user/deposit', 'UserController@deposit' )->name( 'user.deposit.view' );
Route::post( 'user/deposit', 'UserController@deposit' )->name( 'user.deposit' );
Route::resource( 'user', 'UserController' );

// Token
Route::get( 'token/purchase', 'TokenController@purchase' )->name( 'token.purchase.view' );
Route::post( 'token/purchase', 'TokenController@purchase' )->name( 'token.purchase' );

// Pusher
Route::get( 'pusher/auth', 'PusherController@auth' )->name( 'pusher.auth' );