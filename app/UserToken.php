<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Currency;

class UserToken extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'tokens',
		'token_rate',
		'currency',
		'currency_rate',
		'meta_data',
		'phase_id',
		'currency_value'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];

	protected $appends = [
		'btc_value'
	];

	public function getBtcValueAttribute()
	{
		if ( $this->currency == 'BTC' ) {
			return Currency::convertToBtc( $this->currency_rate );
		}

		return false;
	}

	public function getMetaDataAttribute( $value )
	{
		if ( ! empty( $value ) ) {
			return json_decode( $value, true );
		}

		return [];
	}

	public function setMetaDataAttribute( $value )
	{
		$this->attributes['meta_data'] = json_encode( $value );
	}

	public function user()
	{
		return $this->belongsTo( 'App\User', 'user_id' );
	}

	public function phase()
	{
		return $this->belongsTo( 'App\Phase', 'phase_id' );
	}

	public static function getUserTokens( $user_id, $sum = 'tokens' )
	{
		return UserToken::where( 'user_id', $user_id )
		                ->groupBy( 'phase_id' )
		                ->sum( $sum );
	}

	public static function getUserTokensByPhase( $user_id, $phase_id, $sum = 'tokens' )
	{
		return UserToken::where( 'user_id', $user_id )
		                ->where( 'phase_id', $phase_id )
		                ->groupBy( 'phase_id' )
		                ->sum( $sum );
	}

	public static function getTotalSoldTokens()
	{
		return UserToken::sum( 'tokens' );
	}
}