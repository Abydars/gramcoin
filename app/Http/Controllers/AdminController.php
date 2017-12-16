<?php

namespace App\Http\Controllers;

use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Dashboard;

class AdminController extends PanelController
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware( [ 'administrator' ] );
	}

	public function show_transaction_request( $id )
	{
		$transaction = Transaction::find( $id );

		if ( $transaction ) {

			if ( $transaction->status != 'requested' ) {
				return response()
					->redirectToRoute( 'wallet.transactions.show', [ $transaction->id ] );
			}

			Dashboard::setTitle( 'Withdrawal Request' );

			return view( 'transaction.request', [
				'transaction' => $transaction
			] );
		}

		return response()->redirectToRoute( 'wallet.transactions' );
	}

	public function response_transaction_request( $id, Request $request )
	{
		$accepted    = $request->get( 'accepted' );
		$transaction = Transaction::find( $id );

		if ( $transaction ) {

			$wallet = $transaction->wallet;

			if ( $accepted ) {
				try {
					$tx = $wallet->pay( $transaction->recipient, $transaction->amount );

					$txData = array(
						'tx_hash'       => $tx,
						'tx_time'       => Carbon::now(),
						'recipient'     => $transaction->recipient,
						'direction'     => 'sent',
						'amount'        => $transaction->amount,
						'confirmations' => 0,
						'status'        => 'unconfirmed',
						'wallet_id'     => $wallet->id,
					);

					$transaction->fill( $txData );

					if ( $transaction->save() ) {

						return response()
							->redirectToRoute( 'wallet.transactions.show', [ $transaction->id ] );

					} else {
						$transaction->status = 'failed';
					}
				} catch ( \Exception $e ) {
					$transaction->status = 'failed';
				}

			} else {
				$transaction->status = 'declined';
			}

			$transaction->save();

			return response()->redirectToRoute( 'dashboard' );
		}
	}
}
