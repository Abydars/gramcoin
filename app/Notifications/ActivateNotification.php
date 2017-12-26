<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActivateNotification extends Notification //implements ShouldQueue
{
	//use Queueable;

	protected $token;

	public function __construct( $token )
	{
		$this->token = $token;
	}

	public function via( $notifiable )
	{
		return [ 'mail' ];
	}

	public function toMail( $notifiable )
	{
		$link = route( 'activate.activation', $this->token );
		$user = $notifiable;

		return ( new MailMessage() )
			->greeting( "Hello, {$user->full_name}" )
			->line( 'You are almost done!' )
			->action( 'Verification', $link )
			->line( 'Thank you for using our application!' );
	}
}
