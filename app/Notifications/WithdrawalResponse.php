<?php

namespace App\Notifications;

use App\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WithdrawalResponse extends Notification
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
		$mail_message = new MailMessage;

		if ( $this->transaction->status == 'processing' ) {
			$mail_message
				->subject( 'Withdrawal Request Accepted' )
				->line( 'Your withdrawal request has been accepted.' );

		} else if ( $this->transaction->status == 'failed' ) {
			$mail_message
				->subject( 'Withdrawal Processing Failed' )
				->line( 'Your withdrawal request was failed in processing. Please try again.' );
		} else if ( $this->transaction->status == 'declined' ) {
			$mail_message
				->subject( 'Withdrawal Request Declined' )
				->line( 'Your withdrawal request has been declined.' );
		} else if ( $this->transaction->status == 'insufficient balance' ) {
			$mail_message
				->subject( 'Withdrawal Processing Failed' )
				->line( 'Your withdrawal processing failed due to insufficient balance.' );
		}

		$mail_message->line( 'Amount: ' . number_format( $this->transaction->amount_in_btc, 8 ) . ' BTC' );

		if ( $fee = $this->transaction->getMetaDataByKey( 'fee' ) ) {
			$mail_message->line( 'Transaction fee: ' . Currency::convertToBtc( $fee ) . ' BTC' );
		}

		$mail_message->action( 'View Transaction', route( 'wallet.transactions.show', [ $this->transaction->id ] ) );

		return $mail_message;
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
