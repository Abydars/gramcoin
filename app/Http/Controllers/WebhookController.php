<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\UserWallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Currency;

class WebhookController extends Controller
{
	public function transactionEvent( $identifier, Request $request )
	{
		$event_type = $request->get( 'event_type' );
		$data       = $request->get( 'data' );
		$wallet     = UserWallet::where( 'identifier', $identifier );

		file_put_contents( storage_path( 'logs' ) . '/' . $identifier . '.json', json_encode( $data ) );

		if ( $wallet->exists() ) {
			$wallet = $wallet->first();
		}

		switch ( $event_type ) {
			case "address-transactions":

				$txData = [
					'recipient'     => $data['outputs'][0]['address'],
					'direction'     => 'received',
					'amount'        => $data['estimated_value'],
					'confirmations' => $data['confirmations'],
					'wallet_id'     => $wallet->id,
					'tx_time'       => Carbon::now()
				];

				$transaction = Transaction::firstOrCreate( [ 'tx_hash' => $data['hash'] ], $txData );

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