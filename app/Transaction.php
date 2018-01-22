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
		'status',
		'meta_data'
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

	public function getMetaDataByKey( $key )
	{
		$this->meta_data = json_decode( $this->meta_data, true );

		return isset( $this->meta_data[ $key ] ) ? $this->meta_data[ $key ] : false;
	}

	public function setMetaDataByKey( $key, $value )
	{
		$this->meta_data         = json_decode( $this->meta_data, true );
		$this->meta_data[ $key ] = $value;
		$this->meta_data         = json_encode( $this->meta_data );
	}
}
