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
Route::post( 'webhook/{wallet}', 'WebhookController@transactionEvent' )->name( 'webhook.transaction' );

Route::get( 'tokens/info', 'ApiController@tokens_info' );
Route::get( 'rates', 'ApiController@rates' );