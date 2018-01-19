<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;

class WalletHelper
{
	private $blocktrail;
	private $wallet;

	public function __construct()
	{
		$identity = env( 'WALLET_IDENTITY' );
		$password = env( 'WALLET_PASSWORD' );

		$this->blocktrail = App::make( 'Blocktrail' );
		$this->wallet     = $this->blocktrail->initWallet( $identity, $password );
	}

	public function getAddressBalance( $address )
	{
		$addresses = $this->wallet->addresses();

		foreach ( $addresses['data'] as $add ) {
			if ( $add['address'] == $address ) {
				return [
					$add['balance'],
					$add['unc_balance']
				];
			}
		}

		return false;
	}

	public function getBalance()
	{
		list( $balance, $unc_balance ) = $this->wallet->getBalance();

		return [
			'balance'     => $balance,
			'unc_balance' => $unc_balance
		];
	}

	public function pay( $from, $address, $amount )
	{
		return $this->wallet->pay( array( $address => $amount ), $from );
	}

	public function getNewAddress()
	{
		return $this->wallet->getNewAddress();
	}
}