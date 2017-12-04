<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Blockchain\Blockchain;
use Blockchain\Create\WalletResponse;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

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
	private $blockchain;

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware( 'guest' );

		$this->blockchain = new Blockchain( env( 'BLOCKCHAIN_KEY' ) );
		$this->blockchain->setServiceUrl( 'http://localhost:3000' );
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
		//$this->blockchain->Wallet->credentials( env( 'BLOCKCHAIN_KEY' ), env( 'BLOCKCHAIN_PASS' ) );
		//var_dump($this->blockchain->Create->create('12345678910', 'test@none.net'));
		//exit;

		return User::create( [
			                     'full_name' => $data['full_name'],
			                     'username'  => $data['username'],
			                     'email'     => $data['email'],
			                     'password'  => bcrypt( $data['password'] )
		                     ] );
	}
}
