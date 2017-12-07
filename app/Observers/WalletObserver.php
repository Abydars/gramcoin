<?php

namespace App\Observers;

use App\UserWallet;
use Illuminate\Support\Facades\App;

class WalletObserver
{
	/**
	 * @param UserWallet $wallet
	 *
	 * @return bool
	 */
	public function created( UserWallet $wallet )
	{
		$bitcoinClient = App::make( 'Blocktrail' );

		try {
			list( $wallet, $primaryMnemonic, $backupMnemonic, $blocktrailPublicKeys ) = $bitcoinClient->createNewWallet( $wallet->identity, $wallet->pass );

			$wallet->primary_mnemonic = $primaryMnemonic;
			$wallet->backup_mnemonic  = $backupMnemonic;
			$wallet->blocktrail_keys  = $blocktrailPublicKeys;

		} catch ( \Exception $e ) {
			return false;
		}
	}

	/**
	 * Listen to the User deleting event.
	 *
	 * @param UserWallet $wallet
	 *
	 * @return void
	 * @internal param \App\User $user
	 *
	 */
	public function deleting( UserWallet $wallet )
	{
		//
	}
}