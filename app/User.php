<?php

namespace App;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Currency;
use Referral;

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
		'wallet_id',
		'role',
		'google2fa_secret'
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
		'token_balance',
		'btc_balance_in_btc',
		'status',
		'spend',
		'unc_balance',
		'unc_balance_formatted'
	];

	public function getUncBalanceFormattedAttribute()
	{
		$unc_minus = $this->getMetaDataByKey( 'unc_minus' );
		$unc_plus  = $this->getMetaDataByKey( 'unc_plus' );

		if ( $unc_plus ) {
			$unc_plus = Currency::convertToBtc( $unc_plus );
			$unc_plus = number_format( $unc_plus, 4 );
		} else {
			$unc_plus = number_format( 0, 8 );
		}

		if ( $unc_minus ) {
			$unc_minus = Currency::convertToBtc( $unc_minus );
			$unc_minus = number_format( $unc_minus, 4 );
		} else {
			$unc_minus = number_format( 0, 8 );
		}

		return "-{$unc_minus}, {$unc_plus}";
	}

	public function getUncBalanceAttribute()
	{
		$unc_minus = $this->getMetaDataByKey( 'unc_minus' );
		$unc_plus  = $this->getMetaDataByKey( 'unc_plus' );

		return [
			'minus' => $unc_minus,
			'plus'  => $unc_plus
		];
	}

	public function getSpendAttribute()
	{
		$total = 0;

		UserToken::where( 'user_id', $this->id )->each( function ( $token ) use ( &$total ) {
			$total += $token->currency_value;
		} );

		return Currency::convertToBtc( $total );
	}

	public function getStatusAttribute()
	{
		switch ( $this->activated ) {
			case 1:
				return 'Active';
			case 0:
				return 'Inactive';
			case 2:
				return 'Suspended';
		}
	}

	public function getBtcBalanceInBtcAttribute()
	{
		return Currency::convertToBtc( $this->btc_balance );
	}

	public function setBtcBalanceInBtcAttribute( $value )
	{
		$this->attributes['btc_balance'] = Currency::convertToSatoshi( $value );
	}

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

	public function setMetaDataAttribute( $value )
	{
		$this->attributes['meta_data'] = json_encode( $value );
	}

	public function getMetaDataByKey( $key )
	{
		return isset( $meta_data[ $key ] ) ? $meta_data[ $key ] : false;
	}

	public function setMetaDataByKey( $key, $value )
	{
		$meta_data         = $this->meta_data;
		$meta_data[ $key ] = $value;
		$this->meta_data   = json_encode( $meta_data );
	}

	public function addUncMinus( $amount )
	{
		$unc_minus = $this->getMetaDataByKey( 'unc_minus' );
		$unc_minus = intval( $unc_minus ) + $amount;
		$this->setMetaDataByKey( 'unc_minus', $unc_minus );
	}

	public function MinusUncMinus( $amount )
	{
		$unc_minus = $this->getMetaDataByKey( 'unc_minus' );
		$unc_minus = intval( $unc_minus ) - $amount;
		$this->setMetaDataByKey( 'unc_minus', $unc_minus );
	}

	public function addUncPlus( $amount )
	{
		$unc_plus = $this->getMetaDataByKey( 'unc_plus' );
		$unc_plus = intval( $unc_plus ) + $amount;
		$this->setMetaDataByKey( 'unc_plus', $unc_plus );
	}

	public function MinusUncPlus( $amount )
	{
		$unc_plus = $this->getMetaDataByKey( 'unc_plus' );
		$unc_plus = intval( $unc_plus ) - $amount;
		$this->setMetaDataByKey( 'unc_plus', $unc_plus );
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

	public function getReferralBonuses()
	{
		return Referral::getUserBonuses( $this->id );
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
