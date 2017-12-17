<?php

namespace App\Helpers;

use App;
use App\User;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Option;
use Currency;

class ReferralHelper
{
	public function generateGuid()
	{
		$length           = 10;
		$characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen( $characters );
		$randomString     = '';

		for ( $i = 0; $i < $length; $i ++ ) {
			$randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
		}

		if ( $this->guidExists( $randomString ) ) {
			$randomString = $this->generate_guid();
		}

		return $randomString;
	}

	public function referralCount( $user_id )
	{
		return App\UserReferral::where( 'referred_by', $user_id )->count();
	}

	public function guidExists( $guid )
	{
		return User::where( 'guid', $guid )->exists();
	}

	public function getReferredBy( $user_id )
	{
		$reference = App\UserReferral::where( 'user_id', $user_id );

		return ( $reference->exists() ? $reference->first()->referred_by : false );
	}

	public function assignReference( $user_id, $guid )
	{
		$referred_by = User::where( 'guid', $guid );

		if ( $referred_by->exists() ) {
			$referred_by = $referred_by->first();

			App\UserReferral::create( [
				                          'user_id'     => $user_id,
				                          'referred_by' => $referred_by->id
			                          ] );
		}
	}

	public function distributeTokenBonuses( $user_id, $amount )
	{
		$token_rate   = Currency::getGcValue();
		$percentages  = Option::getReferralPercentages();
		$distribution = [];

		for ( $i = 0; $i < count( $percentages ); $i ++ ) {
			$reference = $this->getReferredBy( $user_id );
			if ( $reference ) {
				$percent                        = $percentages[ $i ];
				$amount                         = $amount * ( $percent / 100 );
				$tokens                         = round( $amount * $token_rate );
				$distribution[ $reference->id ] = [ 'percent' => $percent, 'tokens' => $tokens ];

				App\UserToken::create( [
					                       'user_id'    => $reference->id,
					                       'tokens'     => $tokens,
					                       'token_rate' => $token_rate,
					                       'currency'   => 'USD',
					                       'meta_data'  => json_encode( [
						                                                    'is_referral_bonus' => true
					                                                    ] )
				                       ] );

				$user_id = $reference->id;
			} else {
				break;
			}
		}

		return $distribution;
	}
}