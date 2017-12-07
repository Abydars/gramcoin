<?php

namespace App\Helpers;

use App;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CurrencyHelper
{
	public function convertToSatoshi( $btc )
	{
		return $btc * 100000000;
	}

	public function getGcValue( $currency = 'USD' )
	{
		$usd = 0.5;

		switch ( $currency ) {
			case 'USD':
				return $usd;
		}

		return false;
	}

	public function getBtcValue( $currency = 'USD' )
	{
		$blocktrail = \Illuminate\Support\Facades\App::make( 'Blocktrail' );

		try {
			$btc_value = $blocktrail->price();

			Cache::put( 'btc_value', $btc_value, Carbon::now()->addDay() );

		} catch ( \Exception $e ) {
			$btc_value = Cache::get( 'btc_value', function () {
				return ( - 1 );
			} );
		}

		return isset( $btc_value[ $currency ] ) ? $btc_value[ $currency ] : false;
	}
}