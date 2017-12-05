<?php

namespace App\Providers;

//use Blockchain\Blockchain;
use Illuminate\Support\ServiceProvider;

class BlockChainServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		/*
		$this->app->singleton( Blockchain::class, function ( $app ) {
			$config = $app['config']['services.blockchain'];
			$code   = $config['code'];

			$client = new Blockchain( $code );

			$client->setServiceUrl( 'http://localhost:3000' );
			$client->Wallet->credentials( env( 'BLOCKCHAIN_KEY' ), env( 'BLOCKCHAIN_PASS' ) );

			return $client;
		} );
		*/
	}
}
