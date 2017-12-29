<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Validator;
use Dashboard;
use Currency;

class UserController extends AdminController
{
	public function index()
	{
		$active_users   = User::where( 'activated', '1' )->count();
		$inactive_users = User::where( 'activated', '0' )->count();

		Dashboard::setTitle( 'Users' );

		return view( 'user.index', [
			'active_users'   => $active_users,
			'inactive_users' => $inactive_users
		] );
	}

	public function data()
	{
		return Datatables::of( User::all() )->make( true );
	}

	public function show( $id, Request $request )
	{
		$user   = User::find( $id );
		$wallet = $user->wallet;
		$error  = false;

		try {
			$wallet_balance = Currency::convertToBtc( $wallet->getBalance() );
		} catch ( \Exception $e ) {
			$wallet_balance = 0;
		}

		if ( $request->isMethod( 'POST' ) ) {
			if ( $request->has( 'status' ) ) {

				$user->activated = $request->get( 'status' );

				if ( ! $user->save() ) {
					$error = 'Failed to update status';
				}
			}

			if ( $request->has( 'balance' ) ) {
				try {
					$balance           = $request->input( 'balance' );
					$user->btc_balance = Currency::convertToSatoshi( $balance );

					if ( ! $user->save() ) {
						$error = 'Failed to update balance';
					}

				} catch ( \Exception $e ) {
					$error = 'Please input the balance in numbers';
				}
			}
		}

		$name        = ucwords( $user->full_name );
		$user_status = Config::get( 'constants.user_status' );

		Dashboard::setTitle( "{$name}'s Details" );

		return view( 'user.show', [
			'user'           => $user,
			'user_status'    => $user_status,
			'wallet_balance' => $wallet_balance,
			'error'          => $error
		] );
	}
}
