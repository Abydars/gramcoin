<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Webhook
Route::post( 'webhook/GramCoinWallet', 'WebhookController@transactionEvent' )->name( 'webhook.transaction' );

// Auth
//Route::get( 'admin/exists', 'ApiController@admin_exists' );
//Route::post( 'admin/create', 'ApiController@admin_create' );

// Get Info
Route::get( 'tokens/info', 'ApiController@tokens_info' );
Route::get( 'rates', 'ApiController@rates' );
