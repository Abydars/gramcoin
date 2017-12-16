<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReferral extends Model
{
	protected $table = 'referrals';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'referred_by'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
	
	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo( 'App\User', 'user_id' );
	}

	public function referred_user()
	{
		return $this->belongsTo( 'App\User', 'referred_by' );
	}
}
