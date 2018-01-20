<?php

namespace App\Http\Controllers;

use App\Notifications\WithdrawalRequest;
use App\Transaction;
use App\User;
use App\UserToken;
use App\UserWallet;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Currency;
use Illuminate\Support\Facades\Notification;
use Validator;
use Blocktrail;
use Referral;

class WalletController extends PanelController
{
	private $blocktrail;

	public function __construct( Blocktrail $blocktrail )
	{
		parent::__construct();

		$this->blocktrail = $blocktrail;
	}

	public function index()
	{
		$user   = Auth::user();
		$wallet = $user->wallet;

		$token_rate = Currency::getTokenValue();
		$address    = $user->addresses->where( 'is_used', false )->first();

		try {
			$wallet->getBalance();
			$unc_balance = Currency::convertToBtc( $wallet->unc_balance );
		} catch ( Exception $e ) {
			$unc_balance = 0;
		}

		$btc_balance = $user->btc_balance_in_btc;

		if ( $address ) {
			$address = $address->address;
		}

		return view( 'wallet.index', [
			'user'        => $user,
			'btc_balance' => number_format( $btc_balance, 8 ),
			'unc_balance' => number_format( $unc_balance, 8 ),
			'token_rate'  => $token_rate,
			'wallet'      => $user->wallet,
			'address'     => $address,
			'bonus'       => $user->getReferralBonuses(),
			'referrals'   => Referral::referralCount( $user->id )
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

		$response = response();
		$balance  = $user->btc_balance;

		try {
			$wallet->getBalance();
			$unc_balance = $wallet->unc_balance;
		} catch ( Exception $e ) {

			return $response->redirectToRoute( 'wallet.index' )
			                ->withErrors( [
				                              'error' => 'Failed to get balance, Please try again later'
			                              ] )
			                ->withInput();

		}

		$balance += $unc_balance;
		$amount  = intval( Currency::convertToSatoshi( $request->get( 'amount' ) ) );

		if ( $amount > $balance ) {
			$response = $response->redirectToRoute( 'wallet.index' )
			                     ->withErrors( [
				                                   'error' => 'Insufficient Balance to withdraw'
			                                   ] )
			                     ->withInput();
		} else {

			$after_fee_balance = $balance - $amount;
			$transaction_fee   = Option::getTransactionFee();

			if ( $after_fee_balance < $transaction_fee ) {
				$response = $response->redirectToRoute( 'wallet.index' )
				                     ->withErrors( [
					                                   'error' => 'Insufficient Balance to pay fee: ' . $transaction_fee
				                                   ] )
				                     ->withInput();
			}

			$txData = array(
				'tx_hash'       => 'REQUEST WITHDRAWAL WITH FEE: ' . $tx->getFee(),
				'tx_time'       => Carbon::now(),
				'recipient'     => $request->get( 'address' ),
				'direction'     => 'sent',
				'amount'        => $amount,
				'confirmations' => 0,
				'status'        => 'requested',
				'wallet_id'     => $wallet->id
			);

			$transaction    = Transaction::firstOrCreate( $txData );
			$administrators = User::where( 'role', 'administrator' )->get();

			try {
				Notification::send( $administrators, new WithdrawalRequest( $transaction ) );
			} catch ( Exception $e ) {
				$transaction->delete();

				return $response->redirectToRoute( 'wallet.index' )
				                ->withErrors( [
					                              'error' => 'Failed to request withdrawal (' . $e->getMessage() . '), Please try again later'
				                              ] )
				                ->withInput();
			}

			$response = $response->redirectToRoute( 'wallet.transactions', [ $transaction->id ] );
		}

		return $response;
	}
}
