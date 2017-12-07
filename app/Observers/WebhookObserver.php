<?php

namespace App\Observers;

use App\Webhook;
use Exception;
use Illuminate\Support\Facades\App;

class WebhookObserver
{
	/**
	 * @param Webhook $webhook
	 *
	 * @return bool
	 * @internal param UserWallet $wallet
	 *
	 */
	public function saving( Webhook $webhook )
	{
		$bitcoinClient = App::make( 'Blocktrail' );

		try {
			if ( $webhook->wallet ) {
				$newWebhook = $bitcoinClient->setupWalletWebhook( $webhook->wallet->identity, $webhook->identifier, $webhook->url );
			} else {
				$newWebhook = $bitcoinClient->setupWebhook( $webhook->url, $webhook->identifier );
			}
		} catch ( Exception $e ) {
			return false;
		}
	}

	public function deleting( Webhook $webhook )
	{
		$bitcoinClient = App::make( 'Blocktrail' );

		try {
			if ( $webhook->wallet ) {
				$result = $bitcoinClient->deleteWalletWebhook( $webhook->wallet->identity, $webhook->identifier );
			} else {
				$result = $bitcoinClient->deleteWebhook( $webhook->identifier );
			}
		} catch ( Exception $e ) {
			return false;
		}
	}
}