<?php

namespace App\Http\Controllers;

use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Currency;

class WebhookController extends Controller
{
	public function transactionEvent( $id, Request $request )
	{
		$event_type = $request->get( 'event_type' );
		$data       = $request->get( 'data' );
		$wallet     = $request->get( 'wallet' );

		switch ( $event_type ) {
			case "address-transactions":
				$transaction = Transaction::firstOrCreate( [
					                                           'tx_hash'       => $data['hash'],
					                                           'recipient'     => $data['outputs'][0]['address'],
					                                           'direction'     => 'received',
					                                           'amount'        => Currency::convertToBtc( $data['estimated_value'] ),
					                                           'confirmations' => $data['confirmations'],
					                                           'wallet_id'     => $wallet['identifier'],
					                                           'tx_time'       => Carbon::now()
				                                           ] );
				if ( $transaction->id > 0 ) {
					return response()->json( [
						                         'code'    => 200,
						                         'message' => 'Transaction ID: ' . $transaction->id
					                         ] );
				} else {
					return response()->json( [
						                         'code'    => 400,
						                         'message' => 'Failed to create transaction'
					                         ] );
				}
				break;
		}
	}
}