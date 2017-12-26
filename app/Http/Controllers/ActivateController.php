<?php

namespace App\Http\Controllers;

use App\Notifications\WithdrawalRequest;
use App\Services\ActivationService;
use App\Transaction;
use Illuminate\Support\Facades\Auth;

class ActivateController extends Controller
{
	protected $activationService;
	protected $redirectPath = 'dashboard';

	public function __construct( ActivationService $activationService )
	{
		$this->middleware( 'auth' );
		$this->activationService = $activationService;
	}

	public function index()
	{
		$user = Auth::user();

		if ( ! $user->activated ) {
			$this->activationService->sendActivationMail( $user );

			return view( 'activate.index' );
		}

		return redirect( $this->redirectPath );
	}

	public function activation( $token )
	{
		if ( $user = $this->activationService->activateUser( $token ) ) {
			return redirect( $this->redirectPath );
		}

		return redirect()->route( 'activate.index' );
	}

	public function send()
	{
		$user = Auth::user();
		if ( ! $user->activated ) {
			$this->activationService->forceSendActivationMail( $user );
		}

		return redirect()->route( 'activate.index' );
	}
}
