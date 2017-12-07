<?php

namespace App\Http\Controllers;

use App\Facades\FormatFacade;
use App\UserTransaction;
use Blocktrail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Currency;
use Illuminate\Support\Facades\Cache;

class DashboardController extends AdminController
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

		var_dump($wallet->getBalance());

		try {
			$btc_value = $this->blocktrail->price();

			Cache::put( 'btc_value', $btc_value, Carbon::now()->addDay() );

		} catch ( \Exception $e ) {
			$btc_value = Cache::get( 'btc_value', function () {
				return ( - 1 );
			} );
		}

		return view( 'dashboard.dashboard', [
			'user'       => $user,
			'token_rate' => 0.95,
			'btc_value'  => number_format( $btc_value['USD'], 2 )
		] );
	}
}
