<?php

namespace App\Providers;

use App\Helpers\FormatHelper;
use App\Helpers\ReferralHelper;
use App\Helpers\WalletHelper;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use App\Helpers\DashboardHelper;
use App\Helpers\ElementHelper;
use App\Helpers\CurrencyHelper;
use App\Helpers\OptionsHelper;
use App;

class LaravelLoggerProxy
{
	public function log( $msg )
	{
		Log::info( $msg );
	}
}

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @param UrlGenerator $url
	 */
	public function boot( UrlGenerator $url )
	{
		$pusher = $this->app->make( 'pusher' );
		$pusher->set_logger( new LaravelLoggerProxy() );

		//$url->forceSchema('https');

		//App\UserWallet::observe( App\Observers\WalletObserver::class );
		//App\Webhook::observe( App\Observers\WebhookObserver::class );
	}

	/**
	 * Register any application services.
	 */
	public function register()
	{
		$this->app->singleton( 'element', function ( $app ) {
			$element = new ElementHelper();

			return $element;
		} );

		$this->app->singleton( 'dashboard', function ( $app ) {
			$dashboard = new DashboardHelper();

			return $dashboard;
		} );

		$this->app->singleton( 'format', function ( $app ) {
			$format = new FormatHelper();

			return $format;
		} );

		$this->app->singleton( 'currency', function ( $app ) {
			$currency = new CurrencyHelper();

			return $currency;
		} );

		$this->app->singleton( 'referral', function ( $app ) {
			$referral = new ReferralHelper();

			return $referral;
		} );

		$this->app->singleton( 'option', function ( $app ) {
			$options = new OptionsHelper();

			return $options;
		} );

		$this->app->singleton( 'wallet', function ( $app ) {
			$wallet = new WalletHelper();

			return $wallet;
		} );
	}

	public function provides()
	{
		return [
			'element',
			'dashboard',
			'format',
			'currency',
			'App\Helpers\ElementHelper',
			'App\Helpers\DashboardHelper',
			'App\Helpers\FormatHelper',
			'App\Helpers\CurrencyHelper',
			'App\Helpers\ReferralHelper',
			'App\Helpers\OptionHelper',
		];
	}
}
