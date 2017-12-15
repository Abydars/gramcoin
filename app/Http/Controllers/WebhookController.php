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

		if ( $wallet ) {
			$user = $wallet->user;

			switch ( $event_type ) {
				case "address-transactions":

					$transaction   = Transaction::where( 'tx_hash', $data['hash'] );
					$was_confirmed = $transaction->status == 'confirmed';
					$is_received   = true;

					$confirmed = $data['confirmations'] > 0;
					$amount    = $data['outputs'][0]['value'];

					$txData = [
						'tx_hash'       => $data['hash'],
						'recipient'     => $data['outputs'][0]['address'],
						'direction'     => 'received',
						'amount'        => $amount,
						'confirmations' => $data['confirmations'],
						'status'        => $confirmed ? 'confirmed' : 'unconfirmed',
						'wallet_id'     => $wallet->id,
						'tx_time'       => Carbon::now()->toDateTimeString()
					];

					//file_put_contents( storage_path( 'logs' ) . '/' . $identifier . '.json', json_encode( $data ) );

					$transaction = Transaction::updateOrCreate( [ 'tx_hash' => $data['hash'] ], $txData );

					if ( $transaction->id > 0 ) {

						if ( $is_received && $confirmed && ! $was_confirmed ) {
							$user->btc_balance += $amount;
							$user->save();
						}

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
}