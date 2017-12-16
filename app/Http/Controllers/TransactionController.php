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

	public function data()
	{
		$user   = Auth::user();
		$wallet = $user->wallet;

		return Datatables::of( Transaction::where( 'wallet_id', $wallet->id )->orderBy( 'created_at', 'desc' ) )->make( true );
	}

	public function show( $id )
	{
		$transaction = Transaction::find( $id );

		if ( $transaction && false == true ) {
			return view( 'transaction.show', [
				'transaction' => $transaction
			] );
		}

		return response()->redirectToRoute( 'wallet.transactions' );
	}
}
