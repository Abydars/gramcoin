<?php

namespace App\Helpers;

use App;
use App\User;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
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

	public function getReferrals( $user_id )
	{
		$referrals = [];

		App\UserReferral::with( [ 'user' ] )->where( 'referred_by', $user_id )->each( function ( $referral ) use ( &$referrals ) {
			$referral    = $referral->toArray();
			$referrals[] = $referral['user'];
		} );

		return $referrals;
	}

	public function getReferralToLevel( $user_id, $level = false )
	{
		$referrals   = [];
		$percentages = Option::getReferralPercentages();
		$total_level = count( $percentages );

		if ( ! $level ) {
			$level = $total_level;
		}

		$rs = $this->getReferrals( $user_id );

		if ( $level > 0 ) {
			foreach ( $rs as $r ) {

				$token_ids = array_map( function ( $token ) {
					return $token['id'];
				}, App\UserToken::where( 'user_id', $r['id'] )->get()->toArray() );

				$r['ico'] = $this->getUserBonuses( $user_id, $token_ids );
				$r['referrals'] = $this->getReferralToLevel( $r, $level - 1 );
				$r['level']     = ( $total_level + 1 ) - $level;

				$referrals[] = $r;
			}

			return $referrals;
		}
	}

	public function getUserBonuses( $user_id, $token_ids = [] )
	{
		$bonuses = App\Bonus::where( 'awarded_to', $user_id )
		                    ->groupBy( 'awarded_to' );

		if ( $token_ids ) {
			$bonuses = $bonuses->whereIn( 'purchase_id', $token_ids );
		}

		return $bonuses->sum( 'amount' );
	}

	public function distributeTokenBonuses( $user_id, $amount, $token_id )
	{
		$token_rate   = Currency::getGcValue();
		$percentages  = Option::getReferralPercentages();
		$distribution = [];

		for ( $i = 0; $i < count( $percentages ); $i ++ ) {
			$reference = $this->getReferredBy( $user_id );
			if ( $reference ) {
				$percent                    = $percentages[ $i ];
				$amount                     = $amount * ( $percent / 100 );
				$tokens                     = round( $amount * $token_rate );
				$distribution[ $reference ] = [ 'percent' => $percent, 'tokens' => $tokens ];

				App\UserToken::create( [
					                       'user_id'    => $reference,
					                       'tokens'     => $tokens,
					                       'token_rate' => $token_rate,
					                       'currency'   => 'USD'
				                       ] );

				App\Bonus::create( [
					                   'awarded_to'  => $reference,
					                   'purchase_id' => $token_id,
					                   'amount'      => $tokens,
					                   'rate'        => $token_rate
				                   ] );

				$user_id = $reference;
			} else {
				break;
			}
		}

		return $distribution;
	}

	public function renderReferralList( $list, $child_id = false )
	{
		$view = View::make( 'layouts.referral_table', [ 'list' => $list, 'id' => $child_id ] )->render();

		return $view;
	}
}