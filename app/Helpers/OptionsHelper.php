<?php

namespace App\Helpers;

use App;
use App\Setting;
use Currency;

class OptionsHelper
{
	public function getReferralPercentages()
	{
		$referral = Setting::get( Setting::REFERRAL_PERCENTS );

		if ( $referral ) {
			return array_filter( explode( ',', $referral ), function ( $v ) {
				return floatval( $v ) || intval( $v );
			} );
		}

		return [
			50,
			40,
			30
		];
	}

	public function getTransactionFee()
	{
		$transaction_fee = Setting::get( Setting::TRANSACTION_FEE );

		if ( $transaction_fee ) {
			return Currency::convertToSatoshi( $transaction_fee );
		}

		return 0;
	}
}