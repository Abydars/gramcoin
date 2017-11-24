<?php

namespace App\Providers;

use App\Helpers\FormatHelper;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use App\Helpers\DashboardHelper;
use App\Helpers\ElementHelper;
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
	 */
	public function boot( UrlGenerator $url )
	{
		$pusher = $this->app->make( 'pusher' );
		$pusher->set_logger( new LaravelLoggerProxy() );

		//$url->forceSchema('https');
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
	}

	public function provides()
	{
		return [
			'element',
			'dashboard',
			'format',
			'App\Helpers\ElementHelper',
			'App\Helpers\DashboardHelper',
			'App\Helpers\FormatHelper'
		];
	}
}
