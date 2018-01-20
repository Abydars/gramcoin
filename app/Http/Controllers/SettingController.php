<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Dashboard;
use Validator;

class SettingController extends AdminController
{
	public function index( Request $request )
	{
		$error   = false;
		$success = false;

		if ( $request->isMethod( 'POST' ) ) {
			$fields_rules = [
				Setting::REFERRAL_PERCENTS => 'required',
				Setting::TRANSACTION_FEE   => 'required'
			];
			$validator    = Validator::make( $request->all(), $fields_rules );

			if ( $validator->fails() ) {
				$error = $validator->errors()->first();
			} else {
				foreach ( $fields_rules as $name => $rule ) {
					Setting::set( $name, $request->input( $name ) );
				}
				$success = 'Settings updated successfully.';
			}
		}

		$all_settings = Setting::getAll();

		Dashboard::setTitle( 'Settings' );

		return view( 'setting.index', array_merge( [
			                                           'error'   => $error,
			                                           'success' => $success
		                                           ], $all_settings ) );
	}
}
