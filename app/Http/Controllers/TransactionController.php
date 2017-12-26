<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Dashboard;

class TransactionController extends PanelController
{
	public function index()
	{
		$user = Auth::user();

		Dashboard::setTitle( 'Transactions' );

		return view( 'transaction.index', [
			'user' => $user
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
