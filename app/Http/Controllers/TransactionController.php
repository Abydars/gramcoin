<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Dashboard;

class TransactionController extends Controller
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

		return Datatables::of( Transaction::where( 'wallet_id', $wallet->id ) )->make( true );
	}

	public function createTransaction( $id, Request $request )
	{
		file_put_contents( public_path() . '/webhook.txt', json_encode( $request->all() ) );
	}
}
