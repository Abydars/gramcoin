<?php

namespace App\Notifications;

use App\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WithdrawalRequest extends Notification
{
	use Queueable;

	private $transaction;

	/**
	 * Create a new notification instance.
	 *
	 * @param Transaction $transaction
	 */
	public function __construct( Transaction $transaction )
	{
		$this->transaction = $transaction;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed $notifiable
	 *
	 * @return array
	 */
	public function via( $notifiable )
	{
		return [ 'mail' ];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed $notifiable
	 *
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail( $notifiable )
	{
		return ( new MailMessage )
			->subject( 'New Withdrawal Request' )
			->line( 'Withdrawal Request from ' . ucwords( $this->transaction->wallet->user->full_name ) )
			->line( number_format( $this->transaction->amount_in_btc, 10 ) . ' BTC' )
			->action( 'Accept Request', route( 'wallet.transactions.show_request', [ $this->transaction->id ] ) );
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed $notifiable
	 *
	 * @return array
	 */
	public function toArray( $notifiable )
	{
		return [
			//
		];
	}
}
