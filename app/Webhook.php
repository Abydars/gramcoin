<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Webhook extends Model
{
	protected $table = 'webhooks';
	protected $bitcoinClient;
	protected $fillable = [
		'identifier',
		'url',
		'wallet_id',
		'last_call'
	];

	public function __construct( $attributes = array() )
	{
		parent::__construct( $attributes );

		$this->bitcoinClient = App::make( 'Blocktrail' );
	}

	public function wallet()
	{
		return $this->belongsTo( 'App\UserWallet', 'wallet_id', 'id' );
	}

	public function subscribeAddressTransactions( $address, $confirmations = 6 )
	{
		return $this->bitcoinClient->subscribeAddressTransactions( $this->identifier, $address, $confirmations );
	}
}
