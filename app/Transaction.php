<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Currency;

class Transaction extends Model
{
	protected $bitcoinClient;

	protected $fillable = [
		'tx_hash',
		'recipient',
		'direction',
		'amount',
		'confirmations',
		'wallet_id',
		'tx_time',
		'status'
	];

	protected $appends = [
		'amount_in_btc'
	];

	public function wallet()
	{
		return $this->belongsTo( 'App\UserWallet', 'wallet_id', 'id' );
	}

	public function getAmountInBtcAttribute()
	{
		return Currency::convertToBtc( $this->amount );
	}

	public function setAmountInBtcAttribute( $value )
	{
		$this->attributes['amount'] = Currency::convertToSatoshi( $value );
	}
}
