<?php

namespace App\Http\Controllers;

use App\Deal;
use App\Facades\FormatFacade;
use App\Invoice;
use App\User;
use App\UserGoal;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Notifications\UserRoleSetNotification;
use Validator;

class UserController extends PanelController
{
	public function index()
	{
		return view( 'user.index' );
	}

	public function data()
	{
		return Datatables::of( User::all() )->make( true );
	}

	public function show( $id )
	{

	}

	public function create( Request $request )
	{
		$user = new User();

		return view( 'user.create', [ 'user' => $user ] );
	}

	public function store( $id )
	{
	}

	public function edit( $id )
	{
		$user = User::find( $id );

		return view( 'user.edit', [
			'user' => $user
		] );
	}

	public function update( $id, Request $request )
	{
		$user      = User::find( $id );
		$activated = filter_var( $request->input( 'activated', 'false' ), FILTER_VALIDATE_BOOLEAN );

		$prev_activated = $user->activated;

		$user->fill( [
			             'activated' => $activated,
		             ] );

		$ret = $user->save();

		if ( $ret == true ) {
			return response()->json( [
				                         'status'  => 'success',
				                         'message' => 'User has been updated successfully.',
			                         ] );
		} else {
			return response()->json( [
				                         'status'  => 'danger',
				                         'message' => 'User could not be updated.',
			                         ] );
		}
	}

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

	public function destroy( $id )
	{
		$ret = User::destroy( $id );

		if ( $ret > 0 ) {
			return response()->json( [
				                         'status'  => 'success',
				                         'message' => 'User has been deleted successfully.',
			                         ] );
		} else {
			return response()->json( [
				                         'status'  => 'danger',
				                         'message' => 'User could not be deleted.',
			                         ] );
		}
	}

	public function deposit()
	{
		$this->title = 'Deposit';

		$user = Auth::user();

		$success    = false;
		$error      = false;
		$btc_value  = 8000;
		$token_rate = 1;

		return view( 'user.deposit', [
			'user'       => $user,
			'btc_value'  => $btc_value,
			'token_rate' => $token_rate,
			'error'      => $error,
			'success'    => $success
		] );
	}
}
