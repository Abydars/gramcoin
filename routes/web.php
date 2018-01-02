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

// Admin Route
Route::get( 'admin/{nonce}', 'Auth\LoginController@admin_login' );

// Referral
Route::get( 'refer/{guid}', 'Auth\RegisterController@referral' )->name( 'register.referral' );

// Coming soon
Route::get( 'soon', 'DashboardController@soon' )->name( 'soon' );

// Support
Route::get( 'support', 'SupportController@index' )->name( 'support.index' );

// Deactivated Controllers
Route::get( 'activate', 'ActivateController@index' )->name( 'activate.index' );
Route::get( 'suspended', 'ActivateController@suspended' )->name( 'activate.suspended' );
Route::get( 'activate/send', 'ActivateController@send' )->name( 'activate.send' );
Route::get( 'activate/{token}', 'ActivateController@activation' )->name( 'activate.activation' );

// 2fa
Route::get( '2fa', 'Google2faController@index' )->name( 'google2fa.index' );
Route::post( '2fa', 'Google2faController@index' );

// Dashboard
Route::get( '/dashboard', 'DashboardController@index' )->name( 'dashboard' );

// User
Route::get( 'user', 'UserController@index' )->name( 'user.index' );
Route::get( 'user/data', 'UserController@data' )->name( 'user.data' );
Route::get( 'user/settings', 'PanelUserController@settings' )->name( 'user.settings.view' );
Route::get( 'user/{user_id}', 'UserController@show' )->name( 'user.show' );
Route::post( 'user/{user_id}', 'UserController@show' );
Route::post( 'user/settings', 'PanelUserController@settings' )->name( 'user.settings' );
Route::post( 'user/settings/google2fa', 'PanelUserController@google2fa' )->name( 'user.settings.google2fa' );

// Token
Route::get( 'ico', 'TokenController@purchase' )->name( 'token.index' );
Route::post( 'ico', 'TokenController@purchase' )->name( 'token.purchase' );

// Wallet
Route::get( 'wallet', 'WalletController@index' )->name( 'wallet.index' );
Route::get( 'wallet/transactions', 'TransactionController@index' )->name( 'wallet.transactions' );
Route::get( 'wallet/transactions/data/', 'TransactionController@data' )->name( 'wallet.transactions.data' );
Route::get( 'wallet/transactions/data/{limit}', 'TransactionController@data' )->name( 'wallet.transactions.limited_data' );
Route::get( 'wallet/transactions/{transaction}', 'TransactionController@show' )->name( 'wallet.transactions.show' );
Route::get( 'wallet/transactions/request/{transaction}', 'AdminController@show_transaction_request' )->name( 'wallet.transactions.show_request' );
Route::post( 'wallet/transactions/response/{transaction}', 'AdminController@response_transaction_request' )->name( 'wallet.transactions.request_response' );
Route::post( 'wallet/withdraw', 'WalletController@withdraw' )->name( 'wallet.withdraw' );

// Phases
Route::get( 'phases', 'PhaseController@index' )->name( 'phase.index' );
Route::get( 'phases/data', 'PhaseController@data' )->name( 'phase.data' );
Route::get( 'phases/add', 'PhaseController@add' )->name( 'phase.add' );
Route::get( 'phases/{phase}/edit', 'PhaseController@edit' )->name( 'phase.edit' );
Route::post( 'phases/add', 'PhaseController@add' )->name( 'phase.add' );
Route::post( 'phases/{phase}/edit', 'PhaseController@edit' )->name( 'phase.edit' );
Route::delete( 'phases/{phase}', 'PhaseController@destroy' )->name( 'phase.destroy' );

// Referrals
Route::get( 'referral', 'ReferralController@index' )->name( 'referral.index' );
Route::get( 'referral/data', 'ReferralController@data' )->name( 'referral.data' );

// Pusher
Route::get( 'pusher/auth', 'PusherController@auth' )->name( 'pusher.auth' );