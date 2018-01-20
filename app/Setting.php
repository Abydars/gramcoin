<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	const TRANSACTION_FEE = 'transaction_fee';
	const REFERRAL_PERCENTS = 'referral_percents';

	public $timestamps = false;
	protected $table = 'settings';

	private static $setting_keys = [
		self::TRANSACTION_FEE,
		self::REFERRAL_PERCENTS
	];

	protected $fillable = [
		'name',
		'value'
	];

	public static function get( $name )
	{
		$setting = Setting::where( 'name', $name )->first();

		return $setting->exists() ? $setting->value : false;
	}

	public static function set( $name, $value )
	{
		return Setting::updateOrCreate( [
			                                'name' => $name
		                                ], [
			                                'value' => $value
		                                ] );
	}

	public static function getAll()
	{
		$settings = [];

		Setting::all()->each( function ( $setting ) use ( &$settings ) {
			$settings[ $setting->name ] = $setting->value;
		} );

		foreach ( self::$setting_keys as $key ) {
			if ( empty( $settings[ $key ] ) ) {
				$settings[ $key ] = false;
			}
		}

		return $settings;
	}
}
