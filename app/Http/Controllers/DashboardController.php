<?php

namespace App\Http\Controllers;

use App\Facades\FormatFacade;
use App\UserTransaction;
use Blocktrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Currency;

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
		$user = Auth::user();

		$btc_value = Currency::getBtcValue();
		$gc_value  = Currency::getGcValue();

		return view( 'dashboard.dashboard', [
			'user'       => $user,
			'token_rate' => number_format( $gc_value, 2 ),
			'btc_value'  => number_format( $btc_value, 2 )
		] );
	}
}
