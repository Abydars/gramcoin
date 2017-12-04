<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'amount',
		'currency',
		'in_out',
		'meta_data'
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
}
