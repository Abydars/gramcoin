<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\UserWallet;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Currency;
use Validator;
use Blocktrail;

class WalletController extends AdminController
{
	private $blocktrail;

	public function __construct( Blocktrail $blocktrail )
	{
		$this->blocktrail = $blocktrail;
	}

	public function index()
	{
		$user   = Auth::user();
		$wallet = $user->wallet;

		$gc_value = Currency::getGcValue();
		$address  = $user->addresses->where( 'is_used', false )->first();

		try {
			$btc_balance = Currency::convertToBtc( $wallet->getBalance() );
		} catch ( Exception $e ) {
			$btc_balance = 0;
		}

		if ( $address ) {
			$address = $address->address;
		}

		return view( 'wallet.index', [
			'user'        => $user,
			'btc_balance' => number_format( $btc_balance, 8 ),
			'token_rate'  => $gc_value,
			'wallet'      => $user->wallet,
			'address'     => $address,
			'bonus'       => 5,
			'referrals'   => 10
		] );
	}

	public function withdraw( Request $request )
	{
		$user   = Auth::user();
		$wallet = $user->wallet;

		$validator = Validator::make( $request->all(), [
			'amount'  => 'required',
			'address' => 'required'
		] );

		if ( $validator->fails() ) {
			$error_message = $validator->errors()->first();

			return response()->redirectToRoute( 'wallet.index' )
			                 ->withErrors( [
				                               'error' => $error_message
			                               ] )
			                 ->withInput();
		}

		try {
			$amount      = intval( Currency::convertToSatoshi( $request->get( 'amount' ) ) );
			$transaction = $wallet->pay( $request->get( 'address' ), $amount );

			$txData = array(
				'tx_hash'       => $transaction,
				'tx_time'       => Carbon::now(),
				'recipient'     => $request->get( 'address' ),
				'direction'     => "sent",
				'amount'        => $request->get( 'amount' ),
				'confirmations' => 0,
				'wallet_id'     => $wallet->id,
			);

			Transaction::firstOrCreate( $txData );

			return response()->redirectToRoute( 'wallet.index' );
		} catch ( \Exception $e ) {
			return response()->redirectToRoute( 'wallet.index' )
			                 ->withErrors( [
				                               'error' => $e->getMessage()
			                               ] )
			                 ->withInput();
		}
	}
}
