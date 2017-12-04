<?php

namespace App\Http\Controllers;

use App\Facades\FormatFacade;
use App\UserTransaction;
use Blockchain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Currency;

class DashboardController extends AdminController
{
	private $blockchain;

	/**
	 * Create a new controller instance.
	 *
	 * @param Blocktrail $blockchain
	 */
	public function __construct( Blockchain $blockchain )
	{
		parent::__construct();

		$this->title      = 'Dashboard';
		$this->blockchain = $blockchain;
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$user = Auth::user();

		return view( 'dashboard.dashboard', [
			'user'       => $user,
			'token_rate' => 0.95,
			'btc_value'  => number_format( $this->blockchain->Rates->fromBTC( Currency::convertToSatoshi(1), 'USD' ), 2 )
		] );
	}
}
