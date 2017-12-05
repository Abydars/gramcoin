<?php

namespace App\Http\Controllers;

use App\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenController extends AdminController
{
	public function __construct()
	{
		parent::__construct();

		$this->title = 'Tokens Management';
	}

	public function purchase( Request $request )
	{
		$user = Auth::user();

		$success    = false;
		$error      = false;
		$btc_value  = 8000;
		$token_rate = 1;

		if ( $request->isMethod( 'POST' ) ) {
			$btc = $request->input( 'bitcoins' );

			if ( $user->btc_balance >= $btc ) {
				$dollars = $btc * $btc_value;
				$tokens  = round( $dollars / $token_rate );

				$user->btc_balance -= $btc;
				$created           = UserToken::create( [
					                                        'user_id'       => $user->id,
					                                        'tokens'        => $tokens,
					                                        'token_rate'    => $token_rate,
					                                        'currency'      => 'BTC',
					                                        'currency_rate' => $btc_value
				                                        ] );

				if ( $created->id > 0 && $user->save() ) {
					$success = "You have successfully bought {$tokens} tokens for {$btc} bitcoin(s).";
				}
			} else {
				$error = 'You don\'t have enough BTC balance';
			}
		}

		return view( 'token.purchase', [
			'user'       => $user,
			'btc_value'  => $btc_value,
			'token_rate' => $token_rate,
			'error'      => $error,
			'success'    => $success
		] );
	}
}
