<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class RedirectIfDeactivated
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next )
	{
		$user = Auth::user();

		if ( $user->activated == '2' ) {
			return redirect( 'suspended' );
		} else if ( $user->activated != '1' ) {
			return redirect( 'activate' );
		}

		$verified        = ( $user->google2fa_secret && $request->session()->has( '2fa:validation' ) );
		$on_verification = $request->route()->getUri() == '2fa';

		if ( $verified || $on_verification || $user->google2fa_secret == null ) {
			return $next( $request );
		} else {
			return redirect( '/2fa' );
		}
	}
}
