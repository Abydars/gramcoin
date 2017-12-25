<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class Google2faController extends PanelController
{
	private $tries = 3;

	public function index( Request $request )
	{
		$user = Auth::user();

		$error = false;
		$tries = $request->session()->get( '2fa:tries' );

		if ( ! $tries ) {
			$tries = 0;
		}

		if ( $request->isMethod( 'POST' ) ) {
			$secret = $request->input( 'secret' );

			$google2fa = new Google2FA();
			$verified  = $google2fa->verifyKey( $user->google2fa_secret, $secret );

			if ( $verified ) {
				$request->session()->put( '2fa:validation', $user->id );

				return response()->redirectToRoute( 'dashboard' );
			} else {
				$error = 'Failed to verify';

				$tries ++;
				$request->session()->put( '2fa:tries', $tries );
			}
		}

		if ( $this->tries - $tries <= 0 ) {
			Auth::logout();
			$request->session()->clear();

			return response()->redirectToRoute( 'login' )->with( [
				                                                     'error' => 'Your account is now deactivated, please contact administrator'
			                                                     ] );
		}

		return view( 'user.google2fa', [
			'error' => $error,
			'tries' => $this->tries - $tries
		] );
	}
}
