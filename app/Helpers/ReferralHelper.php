<?php

namespace App\Helpers;

use App;
use App\User;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

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

	public function referredBy( $user_id )
	{
		$reference = User::where( 'user_id', $user_id );

		return ( $reference->exists() ? $reference->first()->referred_by : false );
	}

	public function assignReference( $user_id, $guid )
	{

	}
}