<?php

namespace App\Http\Controllers;

use App\Deal;
use App\Facades\FormatFacade;
use App\Invoice;
use App\User;
use App\UserGoal;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Notifications\UserRoleSetNotification;
use Validator;

class UserController extends AdminController
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
