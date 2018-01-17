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

	public function getBalance()
	{
		list( $balance, $unc_balance ) = $this->wallet->getBalance();

		return [
			'balance'     => $balance,
			'unc_balance' => $unc_balance
		];
	}

	public function pay( $address, $amount )
	{
		return $this->wallet->pay( array( $address => $amount ) );
	}

	public function getNewAddress()
	{
		return $this->wallet->getNewAddress();
	}
}