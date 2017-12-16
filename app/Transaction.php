<?php

namespace App;

use Carbon\Carbon;
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
		'amount_in_btc',
		'created_at_human'
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

	public function getCreatedAtHumanAttribute()
	{
		return Carbon::parse( $this->tx_time )->toDateTimeString();
	}
}
