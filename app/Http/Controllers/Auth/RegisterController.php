<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserAddress;
use App\UserReferral;
use App\UserWallet;
use App\Webhook;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Referral;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/dashboard';

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware( 'guest' );
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param array $data
	 *
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator( array $data )
	{
		return Validator::make( $data, [
			'full_name' => 'required|max:255',
			'username'  => 'required|max:255|unique:users',
			'email'     => 'required|email|max:255|unique:users',
			'password'  => 'required|min:6|confirmed',
		] );
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param array $data
	 *
	 * @return User
	 */
	protected function create( array $data )
	{
		$wallet = UserWallet::create( [
			                              'identity' => str_random( 40 ),
			                              'name'     => $data['username'],
			                              'pass'     => bcrypt( $data['password'] ),
		                              ] );

		if ( $wallet->id > 0 ) {
			$user = User::create( [
				                      'full_name' => $data['full_name'],
				                      'username'  => $data['username'],
				                      'email'     => $data['email'],
				                      'password'  => bcrypt( $data['password'] ),
				                      'wallet_id' => $wallet->id,
				                      'guid'      => Referral::generateGuid()
			                      ] );

			if ( $user->id > 0 ) {

				UserAddress::create( [
					                     'address' => $wallet->getNewAddress(),
					                     'user_id' => $user->id
				                     ] );

				if ( ! empty( $data['reference'] ) ) {
					Referral::assignReference( $user->id, $data['reference'] );
				}

				$url = route( 'webhook.transaction.notification', [
					'wallet' => $wallet->identity
				] );

				Webhook::create( [
					                 'identifier' => $wallet->identity,
					                 'url'        => $url,
					                 'wallet_id'  => $wallet->id
				                 ] );
			}

			return $user;
		}
	}

	public function referral( $guid )
	{
		$reference = User::where( 'guid', $guid );

		return view( 'auth.register', [
			'guid'   => $guid,
			'exists' => $reference->exists()
		] );
	}
}
