<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UserWallet extends Model
{
	protected $table = 'wallets';
	protected $bitcoinClient;
	protected $liveWallet;

	protected $fillable = [
		'identity',
		'name',
		'pass'
	];

	public function __construct( array $attributes = [] )
	{
		parent::__construct( $attributes );

		$this->bitcoinClient = App::make( 'Blocktrail' );
	}

	public function user()
	{
		return $this->belongsTo( 'App\User' );
	}

	public function webhook()
	{
		return $this->hasOne( 'App\Webhook', 'wallet_id', 'id' );
	}

	public function transactions()
	{
		return $this->hasMany( 'App\Transaction' );
	}

	public function setPasswordAttribute( $value )
	{
		$this->attributes['password'] = Hash::make( $value );
	}

	public function setBlocktrailKeysAttribute( $value )
	{
		$this->attributes['blocktrail_keys'] = json_encode( $value );
	}

	public function getBlocktrailKeysAttribute( $value )
	{
		return json_decode( $value, true );
	}

	public function initLiveWallet()
	{
		$this->liveWallet = $this->bitcoinClient->initWallet( $this->identity, $this->pass );
	}

	public function getBalance()
	{
		if ( ! $this->liveWallet ) {
			$this->initLiveWallet();
		}
		list( $this->balance, $this->unc_balance ) = $this->liveWallet->getBalance();

		return $this->balance;
	}

	public function getNewAddress()
	{
		if ( ! $this->liveWallet ) {
			$this->initLiveWallet();
		}

		return $this->liveWallet->getNewAddress();
	}

	public function pay( $address, $amount )
	{
		if ( ! $this->liveWallet ) {
			$this->initLiveWallet();
		}

		return $this->liveWallet->pay( array( $address => $amount ) );
	}

}
