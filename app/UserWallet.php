<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Wallet;

class UserWallet extends Model
{
	protected $table = 'wallets';

	protected $fillable = [
		'identity',
		'name',
		'pass'
	];

	public function __construct( array $attributes = [] )
	{
		parent::__construct( $attributes );
	}

	public function user()
	{
		return $this->hasOne( 'App\User', 'wallet_id', 'id' );
	}

	public function transactions()
	{
		return $this->hasMany( 'App\Transaction' );
	}

	public function setPasswordAttribute( $value )
	{
		$this->attributes['password'] = Hash::make( $value );
	}

	public function getBalance()
	{
		$user    = User::where( 'wallet_id', $this->id )->first();
		$address = UserAddress::where( 'user_id', $user->id )->first();

		list( $this->balance, $this->unc_balance ) = Wallet::getAddressBalance( $address['address'] );

		return $this->balance;
	}

	public function getNewAddress()
	{
		return Wallet::getNewAddress();
	}

	public function pay( $address, $amount )
	{
		return Wallet::pay( $address, $amount );
	}

}
