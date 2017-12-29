<?php

namespace App\Http\Controllers;

use App\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Dashboard;
use Currency;

class TransactionController extends PanelController
{
	public function index()
	{
		$user    = Auth::user();
		$wallet  = $user->wallet;
		$address = $user->addresses->where( 'is_used', false )->first();

		$btc_value = Currency::getBtcValue();

		try {
			$wallet->getBalance();
			$unc_balance = Currency::convertToBtc( $wallet->unc_balance );
		} catch ( Exception $e ) {
			$unc_balance = 0;
		}

		$btc_balance = $user->btc_balance_in_btc;

		if ( $address ) {
			$address = $address->address;
		}

		Dashboard::setTitle( 'Transactions' );

		return view( 'transaction.index', [
			'user'        => $user,
			'address'     => $address,
			'btc_value'   => $btc_value,
			'btc_balance' => number_format( $btc_balance, 8 ),
			'unc_balance' => number_format( $unc_balance, 8 ),
		] );
	}

	public function data( $limit = false )
	{
		$user   = Auth::user();
		$wallet = $user->wallet;

		$transactions = Transaction::where( 'wallet_id', $wallet->id );

		if ( $limit != false ) {
			$transactions->limit( $limit );
		}

		return Datatables::of( $transactions )->make( true );
	}

	public function show( $id )
	{
		$transaction = Transaction::find( $id );

		Dashboard::setTitle( 'Transactions Details' );

		if ( $transaction ) {
			return view( 'transaction.show', [
				'transaction' => $transaction
			] );
		}

		return response()->redirectToRoute( 'wallet.transactions' );
	}
}
