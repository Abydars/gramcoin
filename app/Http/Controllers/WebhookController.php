<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\UserAddress;
use App\UserWallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Currency;
use Option;

class WebhookController extends Controller
{
	public function _transactionEvent( $identifier, Request $request )
	{
		$event_type      = $request->get( 'event_type' );
		$data            = $request->get( 'data' );
		$wallet          = UserWallet::where( 'identity', $identifier )->first();
		$response_wallet = $request->get( 'wallet' );

		$log = date( "Y-m-d h:i:s" ) . ' : ' . $identifier . ' : ' . json_encode( $request->all() ) . PHP_EOL;
		file_put_contents( storage_path( 'logs' ) . '/transactions.txt', $log, FILE_APPEND );

		if ( $wallet ) {
			$user = $wallet->user;

			switch ( $event_type ) {
				case "address-transactions":
					//return;

					$transaction = Transaction::where( 'tx_hash', $data['hash'] )
					                          ->where( 'wallet_id', $wallet->id );

					$confirmed        = $data['confirmations'] > 0;
					$was_confirmed    = $transaction->exists() && $transaction->first()->status == 'confirmed';
					$wallet_addresses = $response_wallet['addresses'];
					$address          = false;
					$amount           = false;
					$is_sender        = false;
					$has_output       = false;

					foreach ( $data['inputs'] as $input ) {
						$is_sender = in_array( $input['address'], $wallet_addresses );

						$output_index = 0;//$input['output_index'];
						$amount       = $data['outputs'][ $output_index ]['value'];
						$address      = $data['outputs'][ $output_index ]['address'];
						$has_output   = in_array( $address, $wallet_addresses );

						if ( $has_output ) {
							break;
						}
					}

					if ( ! $is_sender && ! $has_output ) {
						return;
					}

					$txData = [
						'tx_hash'       => $data['hash'],
						'recipient'     => $address,
						'direction'     => $is_sender ? 'sent' : 'receiver',
						'amount'        => $amount,
						'confirmations' => $data['confirmations'],
						'status'        => $confirmed ? 'confirmed' : 'unconfirmed',
						'wallet_id'     => $wallet->id,
						'tx_time'       => Carbon::now()->toDateTimeString()
					];

					$transaction = Transaction::updateOrCreate( [
						                                            'tx_hash'   => $data['hash'],
						                                            'wallet_id' => $wallet->id
					                                            ], $txData );

					if ( $transaction->id > 0 ) {

						if ( $confirmed && ! $was_confirmed ) {

							if ( $is_sender ) {
								$user->btc_balance -= $amount;
							} else {
								$user->btc_balance += $amount;
							}

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

	public function transactionEvent( $identifier, Request $request )
	{
		$event_type      = $request->get( 'event_type' );
		$data            = $request->get( 'data' );
		$response_wallet = $request->get( 'wallet' );

		$log = date( "Y-m-d h:i:s" ) . ' : ' . $identifier . ' : ' . json_encode( $request->all() ) . PHP_EOL;
		file_put_contents( storage_path( 'logs' ) . '/transactions.txt', $log, FILE_APPEND );

		switch ( $event_type ) {
			case "address-transactions":

				$inputs    = $data['inputs'];
				$outputs   = $data['outputs'];
				$confirmed = $data['confirmations'] > 0;

				$changes = [];

				foreach ( $inputs as $input ) {
					$input_address  = $input['address'];
					$system_address = UserAddress::where( 'address', $input_address )->first();
					$input_output   = $outputs[ $input['output_index'] ];

					if ( $system_address ) {
						if ( $input['output_confirmed'] ) {
							$changes[ $system_address->id ][] = [
								'type'   => 'input',
								'amount' => $input['value']
							];
						}
					}
				}

				foreach ( $outputs as $output ) {
					$output_address = $output['address'];
					$system_address = UserAddress::where( 'address', $output_address )->first();

					if ( $system_address ) {
						$changes[ $system_address->id ][] = [
							'type'   => 'output',
							'amount' => $output['value']
						];
					}
				}

				$log = 'Changes : ' . $identifier . ' : ' . json_encode( $changes ) . PHP_EOL;
				file_put_contents( storage_path( 'logs' ) . '/transactions.txt', $log, FILE_APPEND );

				foreach ( $changes as $address_id => $change ) {
					foreach ( $change as $tx ) {
						$user_address = UserAddress::with( 'user' )->find( $address_id );
						$is_sender    = $tx['type'] == 'input';
						$amount       = $tx['amount'];

						if ( $user_address ) {
							$user = $user_address->user;

							$transaction = Transaction::where( 'tx_hash', $data['hash'] )
							                          ->where( 'wallet_id', $user->wallet_id );

							$was_confirmed = $transaction->exists() && $transaction->first()->status == 'confirmed';

							$txData = [
								'tx_hash'       => $data['hash'],
								'recipient'     => $user_address->address,
								'direction'     => $is_sender ? 'sent' : 'receiver',
								'amount'        => $amount,
								'confirmations' => $data['confirmations'],
								'status'        => $confirmed ? 'confirmed' : 'unconfirmed',
								'wallet_id'     => $user->wallet_id,
								'tx_time'       => Carbon::now()->toDateTimeString()
							];

							$transaction = Transaction::updateOrCreate( [
								                                            'tx_hash'   => $data['hash'],
								                                            'wallet_id' => $user->wallet_id
							                                            ], $txData );

							if ( $transaction->id > 0 ) {
								if ( $confirmed && ! $was_confirmed ) {
									if ( $is_sender ) {
										$transaction_fee = Option::getTransactionFee();

										if ( $fee = $transaction->getMetaDataByKey( 'fee' ) ) {
											$transaction_fee = $fee;
										}

										$amount            += $transaction_fee;
										$user->btc_balance -= $amount;
									} else {
										$user->btc_balance += $amount;
									}
									$user->save();
								}
							}
						}
					}
				}

				exit();

				break;
		}
	}
}