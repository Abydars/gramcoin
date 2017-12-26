<?php

namespace App\Http\Controllers;

use App\Phase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Dashboard;
use Validator;

class PhaseController extends AdminController
{
	public function index()
	{
		return view( 'phase.index' );
	}

	public function data()
	{
		$phases = Phase::all();

		return Datatables::of( $phases )->make( true );
	}

	public function add( Request $request )
	{
		$error   = false;
		$success = false;

		Dashboard::setTitle( 'Add New Phase' );

		if ( $request->isMethod( 'POST' ) ) {
			return $this->store( $request );
		}

		return view( 'phase.add', [
			'error'   => $error,
			'success' => $success
		] );
	}

	private function store( Request $request )
	{
		$error   = false;
		$success = false;

		$validator = Validator::make( $request->all(), [
			'title'      => 'required',
			'tokens'     => 'required',
			'token_rate' => 'required'
		] );

		if ( $validator->fails() ) {
			$error = $validator->errors()->first();
		} else {

			$launch_time = Carbon::parse( $request->input( 'launch_time' ) );

			$phase = Phase::create( [
				                        'title'       => $request->input( 'title' ),
				                        'tokens'      => $request->input( 'tokens' ),
				                        'token_rate'  => $request->input( 'token_rate' ),
				                        'status'      => $request->input( 'status' ),
				                        'launch_time' => $launch_time->toDateTimeString()
			                        ] );

			if ( $phase->id > 0 ) {

				return response()->redirectToRoute( 'phase.index' );

			} else {
				$error = 'Failed to add new phase';
			}
		}

		return view( 'phase.add', [
			'error'   => $error,
			'success' => $success
		] );
	}

	public function edit( $id, Request $request )
	{
		$error   = false;
		$success = false;

		$phase = Phase::find( $id );

		Dashboard::setTitle( 'Edit Phase' );

		if ( $request->isMethod( 'POST' ) ) {
			list( $error, $success ) = $this->update( $phase, $request );
		}

		return view( 'phase.edit', [
			'error'   => $error,
			'success' => $success,
			'phase'   => $phase
		] );
	}

	private function update( Phase $phase, Request $request )
	{
		$error   = false;
		$success = false;

		$validator = Validator::make( $request->all(), [
			'title'      => 'required',
			'tokens'     => 'required',
			'token_rate' => 'required',
			'user_limit' => 'required',
		] );

		if ( $validator->fails() ) {
			$error = $validator->errors()->first();
		}

		$launch_time = Carbon::parse( $request->input( 'launch_time' ) );

		$phase->fill( [
			              'title'       => $request->input( 'title' ),
			              'tokens'      => $request->input( 'tokens' ),
			              'token_rate'  => $request->input( 'token_rate' ),
			              'status'      => $request->input( 'status' ),
			              'user_limit'  => $request->input( 'user_limit' ),
			              'launch_time' => $launch_time->toDateTimeString()
		              ] );

		if ( $phase->save() ) {
			$success = 'Phase edit successfully';
		} else {
			$error = 'Failed to edit phase';
		}

		return [ $error, $success ];
	}

	public function destroy( $id )
	{
		$phase = Phase::find( $id );

		if ( $phase && $phase->delete() ) {
			return response()->json( [
				                         'status'  => 'success',
				                         'message' => 'Phase deleted successfully'
			                         ] );
		}
	}
}
