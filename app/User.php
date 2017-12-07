<?php

namespace App;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use \App\Facades\UtilsFacade;
use \App\UserGoal;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'full_name',
		'username',
		'email',
		'password',
		'avatar',
		'activated',
		'btc_balance',
		'guid',
		'meta_data',
		'wallet_id'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $appends = [
		'token_balance'
	];

	public function getTokenBalanceAttribute()
	{
		$tokens = 0;

		$this->tokens->each( function ( $token ) use ( &$tokens ) {
			$tokens += $token->tokens;
		} );

		return $tokens;
	}

	public function getMetaDataAttribute( $value )
	{
		if ( ! empty( $value ) ) {
			return json_decode( $value, true );
		}

		return [];
	}

	public function setActivatedAttribute( $value )
	{
		$this->attributes['activated'] = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
	}

	public function getActivatedAttribute()
	{
		if ( ! isset( $this->attributes['activated'] ) ) {
			return true;
		}

		if ( $this->attributes['activated'] == true ) {
			return true;
		}

		return false;
	}

	public function setMetaDataAttribute( $value )
	{
		$this->attributes['meta_data'] = json_encode( $value );
	}

	public function tokens()
	{
		return $this->hasMany( 'App\UserToken', 'user_id', 'id' );
	}

	public function utransactions()
	{
		return $this->hasMany( 'App\UserTransaction', 'user_id', 'id' );
	}

	public function wallet()
	{
		return $this->belongsTo( 'App\UserWallet', 'wallet_id', 'id' );
	}

	public function addresses()
	{
		return $this->hasMany( 'App\UserAddress', 'user_id', 'id' );
	}

	public function transactions()
	{
		return $this->hasManyThrough( 'App\Transaction', 'App\UserWallet' );
	}

	/**
	 * The channels the user receives notification broadcasts on.
	 *
	 * @return string
	 */
	public function receivesBroadcastNotificationsOn()
	{
		return 'user.' . $this->id;
	}
}
