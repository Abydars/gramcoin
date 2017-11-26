<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivationService;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/dashboard';
	protected $activationService;

	/**
	 * Create a new controller instance.
	 *
	 * @param ActivationService $activationService
	 */
	public function __construct( ActivationService $activationService )
	{
		$this->middleware( 'guest', [ 'except' => 'logout' ] );
		$this->activationService = $activationService;
	}

	public function login( Request $request )
	{
		$field = filter_var( $request->input( 'email' ), FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';
		$request->merge( [ $field => $request->input( 'email' ) ] );

		if ( Auth::attempt( $request->only( $field, 'password' ), ( $request->input( 'remember' ) == 1 ) ) ) {
			return redirect( $this->redirectTo );
		}

		return $this->sendFailedLoginResponse( $request );
	}

	protected function credentials( Request $request )
	{
		$username = $this->username();
		$field    = filter_var( $request->input( $username ), FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';
		$request->merge( [ $field => $request->input( $username ) ] );

		return $request->only( $field, 'password' );
	}

	public function authenticated( Request $request, $user )
	{
		if ( ! $user->activated ) {
			$this->activationService->sendActivationMail( $user );
			auth()->logout();

			return back()->with( 'warning', 'You need to confirm your account. We have sent you an activation code, please check your email.' );
		}

		return redirect()->intended( $this->redirectPath() );
	}
}
