<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
		'phase_id'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];

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

	public static function getUserTokensByPhase( $user_id, $phase_id )
	{
		return UserToken::where( 'user_id', $user_id )
		                ->where( 'phase_id', $phase_id )
		                ->groupBy( 'phase_id' )
		                ->sum( 'tokens' );
	}
}