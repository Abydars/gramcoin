<?php

namespace App\Http\Controllers;

use App\Notifications\WithdrawalRequest;
use App\Notifications\WithdrawalResponse;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Dashboard;
use Option;

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

			$wallet      = $transaction->wallet;
			$user        = $wallet->user;
			$balance     = $user->btc_balance;
			$unc_balance = $user->unc_balance['minus'];
			$amount      = $transaction->amount;

			if ( $unc_balance > 0 ) {
				$balance -= $unc_balance;
			}

			$transaction_fee   = Option::getTransactionFee();
			$after_fee_balance = $balance - $amount - $transaction_fee;

			if ( $accepted && $after_fee_balance >= 0 ) {
				try {
					$tx = $wallet->pay( $transaction->recipient, $amount );

					$txData = array(
						'tx_hash'   => $tx,
						'tx_time'   => Carbon::now(),
						//'recipient'     => $transaction->recipient,
						//'direction'     => 'sent',
						//'amount'        => $transaction->amount,
						//'confirmations' => 0,
						'status'    => 'processing',
						'wallet_id' => $wallet->id,
					);

					$transaction->fill( $txData );

				} catch ( \Exception $e ) {
					$transaction->status = 'failed';
				}

			} else if ( $after_fee_balance < 0 ) {
				$transaction->status = 'insufficient balance';
			} else {
				$transaction->status = 'declined';
			}

			$transaction->save();
			$user->notify( new WithdrawalResponse( $transaction ) );

			return response()
				->redirectToRoute( 'wallet.transactions.show', [ $transaction->id ] );
		}
	}
}
