<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
	public function index()
	{
		$user = Auth::user();

		$address = $user->addresses->where( 'is_used', false )->first();

		return view( 'wallet.index', [
			'wallet'    => $user->wallet,
			'addresses' => $address
		] );
	}

	public function updateWallet( $wallet )
	{

	}
}
