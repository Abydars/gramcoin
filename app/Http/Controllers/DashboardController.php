<?php

namespace App\Http\Controllers;

use App\Facades\FormatFacade;
use App\Notifications\WithdrawalRequest;
use App\Transaction;
use App\User;
use App\UserTransaction;
use Blocktrail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Currency;

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

		$btc_value = Currency::getBtcValue();
		$gc_value  = Currency::getGcValue();

		try {
			$wallet->getBalance();
			$unc_balance = Currency::convertToBtc( $wallet->unc_balance );
		} catch ( Exception $e ) {
			$unc_balance = 0;
		}

		$btc_balance = $user->btc_balance_in_btc;

		return view( 'dashboard.dashboard', [
			'user'        => $user,
			'btc_balance' => number_format( $btc_balance, 8 ),
			'token_rate'  => number_format( $gc_value, 2 ),
			'btc_value'   => number_format( $btc_value, 2 ),
			'unc_balance' => number_format( $unc_balance, 8 )
		] );
	}
}
