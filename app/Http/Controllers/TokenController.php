<?php

namespace App\Http\Controllers;

use App\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Blocktrail;
use Currency;
use Dashboard;
use Option;

class TokenController extends AdminController
{
	public function __construct( Blocktrail $blocktrail )
	{
		parent::__construct();

		$this->blocktrail = $blocktrail;
	}

	public function purchase( Request $request )
	{
		$user = Auth::user();

		$success    = false;
		$error      = false;
		$btc_value  = Currency::getBtcValue();
		$token_rate = Currency::getGcValue();

		if ( $request->isMethod( 'POST' ) ) {
			$btc = $request->input( 'btc' );

			$btc_in_satoshi = Currency::convertToSatoshi( $btc );

			if ( $user->btc_balance >= $btc_in_satoshi ) {
				$dollars = $btc * $btc_value;
				$tokens  = round( $dollars / $token_rate );

				$user->btc_balance -= $btc_in_satoshi;
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

		Dashboard::setTitle( 'ICO Management' );

		return view( 'ico.index', [
			'user'       => $user,
			'btc_value'  => $btc_value,
			'token_rate' => $token_rate,
			'error'      => $error,
			'success'    => $success
		] );
	}
}
