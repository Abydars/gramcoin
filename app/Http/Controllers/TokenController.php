<?php

namespace App\Http\Controllers;

use App\Phase;
use App\UserToken;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Blocktrail;
use Currency;
use Dashboard;
use Option;
use Referral;

class TokenController extends PanelController
{
	public function __construct( Blocktrail $blocktrail )
	{
		parent::__construct();

		$this->blocktrail = $blocktrail;
	}

	public function purchase( Request $request )
	{
		$user   = Auth::user();
		$wallet = $user->wallet;

		$success         = false;
		$error           = false;
		$user_limit      = 0;
		$btc_value       = Currency::getBtcValue();
		$token_rate      = Currency::getTokenValue();
		$inactive_phases = Phase::getInactivePhases();
		$active_phase    = Phase::getActivePhase();
		$past_phases     = Phase::getPastPhases();
		$user_bought     = 0;

		if ( $active_phase ) {
			$user_bought = UserToken::getUserTokensByPhase( $user->id, $active_phase->id );
		} else {
			$error = 'No active phase';
		}

		$btc_balance = $user->btc_balance_in_btc;

		if ( $active_phase ) {
			$user_limit = $active_phase->user_limit;
		}

		if ( $request->isMethod( 'POST' ) && $active_phase ) {
			$btc = $request->input( 'btc' );

			$btc_in_satoshi       = Currency::convertToSatoshi( $btc );
			$btc_value_in_satoshi = Currency::convertToSatoshi( $btc_value );
			$balance              = $user->btc_balance;
			$user_tokens          = UserToken::getUserTokensByPhase( $user->id, $active_phase->id );

			try {
				$wallet->getBalance();
				$unc_balance = $wallet->unc_balance;
			} catch ( Exception $e ) {
				$unc_balance = 0;
				$error       = "Failed to get balance, Please try again later";
			}

			$balance += $unc_balance;

			if ( ! $error ) {
				if ( $balance >= $btc_in_satoshi ) {
					$dollars       = $btc * $btc_value;
					$tokens        = round( $dollars / $token_rate );
					$tokens_in_usd = $tokens * $token_rate;

					if ( $user_limit < ( $user_tokens + $tokens ) ) {
						$error = "Sorry, you don't have enough limit to purchase {$tokens} GRM tokens";
					} else {

						$user->btc_balance -= $btc_in_satoshi;
						$created           = UserToken::create( [
							                                        'user_id'        => $user->id,
							                                        'tokens'         => $tokens,
							                                        'token_rate'     => $token_rate,
							                                        'currency'       => 'BTC',
							                                        'currency_rate'  => $btc_value_in_satoshi,
							                                        'currency_value' => $btc_in_satoshi,
							                                        'phase_id'       => $active_phase->id
						                                        ] );

						if ( $created->id > 0 && $user->save() ) {

							Referral::distributeTokenBonuses( $user->id, $tokens_in_usd, $created->id );

							$success = "You have successfully bought {$tokens} tokens for {$btc} bitcoin(s).";
						}
					}
				} else {
					$error = 'You don\'t have enough BTC balance';
				}
			}
		}

		if ( $active_phase ) {
			$user_bought = UserToken::getUserTokensByPhase( $user->id, $active_phase->id );
		} else {
			$error = 'No active phase';
		}

		Dashboard::setTitle( 'ICO Management' );

		return view( 'ico.index', [
			'user'            => $user,
			'active_phase'    => $active_phase,
			'inactive_phases' => $inactive_phases,
			'past_phases'     => $past_phases,
			'btc_balance'     => $btc_balance,
			'btc_value'       => $btc_value,
			'token_rate'      => $token_rate,
			'user_bought'     => $user_bought,
			'error'           => $error,
			'success'         => $success
		] );
	}
}
