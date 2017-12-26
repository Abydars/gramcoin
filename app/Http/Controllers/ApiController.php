<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Phase;
use App\User;
use App\UserToken;
use Illuminate\Http\Request;
use Currency;

class ApiAdminRegisterHelper extends RegisterController
{
	public function createAdmin( $data )
	{
		$data['role'] = 'administrator';
		$this->create( $data );
	}
}

class ApiController extends Controller
{
	public function tokens_info()
	{
		$sold_tokens = UserToken::getTotalSoldTokens();
		$tokens      = Phase::getTotalTokens();

		return response()->json( [
			                         'status' => 200,
			                         'data'   => [
				                         'total' => $tokens,
				                         'sold'  => $sold_tokens
			                         ]
		                         ] );
	}

	public function rates()
	{
		$btc_value  = Currency::getBtcValue();
		$token_rate = Currency::getTokenValue();

		return response()->json( [
			                         'status' => 200,
			                         'data'   => [
				                         'btc' => $btc_value,
				                         'grm' => $token_rate
			                         ]
		                         ] );
	}

	private function isAdminExists( $email )
	{
		if ( $email ) {
			$user = User::where( 'email', $email )
			            ->where( 'role', 'administrator' );

			return $user->exists();
		}

		return false;
	}

	public function admin_exists( Request $request )
	{
		if ( $request->has( 'email' ) ) {
			$exists = $this->isAdminExists( $request->has( 'email' ) );

			return response()->json( [
				                         'status' => 200,
				                         'data'   => [ 'exists' => $exists ]
			                         ] );
		} else {
			return response()->json( [
				                         'status'  => 404,
				                         'message' => 'Email address required'
			                         ] );
		}
	}

	public function admin_create( Request $request )
	{
		if ( $request->has( 'email' ) && ! $this->isAdminExists( $request->has( 'email' ) ) ) {
			$registerHelper = new ApiAdminRegisterHelper();
			$user           = $registerHelper->createAdmin( $request->all() );

			if ( $user->id > 0 ) {
				return response()->json( [
					                         'status' => 200,
					                         'data'   => [
						                         'user' => $user
					                         ]
				                         ] );
			}
		}

		return false;
	}
}
