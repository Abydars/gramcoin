<?php

namespace App\Http\Controllers;

use App\Facades\FormatFacade;
use App\Notifications\WithdrawalRequest;
use App\Phase;
use App\Transaction;
use App\User;
use App\UserToken;
use App\UserTransaction;
use Blocktrail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Currency;
use Dashboard;

class DashboardController extends PanelController
{
	private $blocktrail;

	/**
	 * Create a new controller instance.
	 *
	 * @param Blocktrail $blocktrail
	 */
	public function __construct( Blocktrail $blocktrail )
	{
		parent::__construct();

		$this->title      = 'Dashboard';
		$this->blocktrail = $blocktrail;
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$user   = Auth::user();
		$wallet = $user->wallet;

		$btc_value    = Currency::getBtcValue();
		$token_rate   = Currency::getTokenValue();
		$active_phase = Phase::getActivePhase();

		if ( $user->role == 'subscriber' ) {
			$user_bought = 0;

			if ( $active_phase ) {
				$user_bought = UserToken::getUserTokensByPhase( $user->id, $active_phase->id );
			}

			$transactions = Transaction::where( 'wallet_id', $user->wallet->id )->orderBy( 'tx_time', 'desc' )->get();

			try {
				$wallet->getBalance();
				$unc_balance = Currency::convertToBtc( $wallet->unc_balance );
			} catch ( Exception $e ) {
				$unc_balance = 0;
			}

			$btc_balance = $user->btc_balance_in_btc;
			$credits     = [];

			$day_before       = 6;
			$last_before_date = Carbon::now( 'UTC' )->subDays( $day_before );

			while ( $day_before > 0 ) {
				$credits[ $last_before_date->toDateString() ] = [
					'percent' => 0
				];

				$last_before_date = $last_before_date->addDay();
				$day_before --;
			}

			return view( 'dashboard.dashboard_v2', [
				'user'         => $user,
				'transactions' => $transactions,
				'active_phase' => $active_phase,
				'credits'      => array_reverse( $credits ),
				'btc_balance'  => number_format( $btc_balance, 8 ),
				'token_rate'   => $token_rate,
				'btc_value'    => $btc_value,
				'unc_balance'  => number_format( $unc_balance, 8 ),
				'user_bought'  => $user_bought
			] );
		} else if ( $user->role == 'administrator' ) {

			$active_users = User::where( 'activated', '1' )->count();
			$top_user     = UserToken::with( [ 'user' ] )->groupBy( 'user_id' )->orderBy( 'tokens', 'desc' )->first();
			$sold_tokens  = UserToken::getTotalSoldTokens();
			$tokens       = Phase::getTotalTokens();

			if ( $top_user ) {
				$top_user = $top_user->user->full_name;
			} else {
				$top_user = 'None';
			}


			return view( 'dashboard.admin', [
				'active_users'    => $active_users,
				'top_user'        => $top_user,
				'sold_tokens'     => $sold_tokens,
				'tokens'          => $tokens,
				'token_rate'      => $token_rate,
				'btc_value'       => $btc_value,
				'active_phase'    => $active_phase,
				'inactive_phases' => $inactive_phases,
				'past_phases'     => $past_phases,
			] );
		}
	}

	public function soon()
	{
		Dashboard::setTitle( 'Coming Soon' );

		return view( 'soon' );
	}
}
