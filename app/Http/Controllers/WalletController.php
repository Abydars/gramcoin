<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Currency;

class WalletController extends Controller
{
	public function index()
	{
		$user = Auth::user();

		$gc_value = Currency::getGcValue();
		$address = $user->addresses->where( 'is_used', false )->first();

		if ( $address ) {
			$address = $address->address;
		}

		return view( 'wallet.index', [
			'user'       => $user,
			'token_rate' => $gc_value,
			'wallet'     => $user->wallet,
			'address'    => $address,
			'bonus'      => 5,
			'referrals'  => 10
		] );
	}

	public function updateWallet( $wallet )
	{

	}
}
