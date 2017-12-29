<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use Validator;
use Dashboard;

class PanelUserController extends PanelController
{
	public function settings( Request $request )
	{
		$error         = false;
		$success       = false;
		$google2fa_url = false;

		$user = Auth::user();

		if ( $request->isMethod( 'POST' ) ) {
			$validator = Validator::make( $request->all(), [
				'password' => 'required|min:6|confirmed',
			] );

			if ( $validator->fails() ) {
				$error = $validator->errors()->first();
			} else {

				$user->password = bcrypt( $request->input( 'password' ) );

				if ( $user->save() ) {
					$success = 'Profile updated successfully';
				}
			}
		}

		if ( $user->google2fa_secret ) {
			$google2fa     = new Google2FA();
			$google2fa_url = $google2fa->getQRCodeGoogleUrl(
				env( 'app_name' ),
				$user->email,
				$user->google2fa_secret
			);
		}

		return view( 'user.settings', [
			'error'         => $error,
			'success'       => $success,
			'google2fa_url' => $google2fa_url,
			'user'          => $user
		] );
	}

	public function google2fa( Request $request )
	{
		$user    = Auth::user();
		$success = false;
		$error   = false;

		if ( $request->isMethod( 'POST' ) ) {
			$enabled = $request->has( 'google2fa' );

			if ( $enabled ) {
				$google2fa              = new Google2FA();
				$user->google2fa_secret = $google2fa->generateSecretKey();
				$success                = 'Two Factor Authentication enabled successfully';

				$request->session()->put( '2fa:validation', $user->id );
			} else {
				$user->google2fa_secret = null;
				$success                = 'Two Factor Authentication disabled successfully';
			}

			if ( ! $user->save() ) {
				$error = 'Failed to ' . ( $enabled ? 'enable' : 'disable' ) . ' two factor authentication';
			}
		}

		return response()->redirectToRoute( 'user.settings' )
		                 ->with( [
			                         'success' => $success,
			                         'error'   => $error
		                         ] );
	}
}
