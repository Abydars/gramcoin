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
		$wallet     = UserWallet::where( 'identity', $identifier )->first();

		switch ( $event_type ) {
			case "address-transactions":

				$confirmed    = $data['inputs'][0]['output_confirmed'];
				$output_index = $data['inputs'][0]['output_index'];

				$txData = [
					'tx_hash'       => $data['hash'],
					'recipient'     => $data['outputs'][ $output_index ]['address'],
					'direction'     => 'received',
					'amount'        => $data['outputs'][ $output_index ]['value'],
					'confirmations' => $data['confirmations'],
					'status'        => $confirmed ? 'confirmed' : 'unconfirmed',
					'wallet_id'     => $wallet->id,
					'tx_time'       => Carbon::now()->toDateTimeString()
				];

				file_put_contents( storage_path( 'logs' ) . '/' . $identifier . '.json', json_encode( $data ) );

				$transaction = Transaction::updateOrCreate( [ 'tx_hash' => $data['hash'] ], $txData );

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