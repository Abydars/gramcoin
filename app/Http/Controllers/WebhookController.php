<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
	public function transactionEvent( $id, Request $request )
	{
		file_put_contents( storage_path( 'logs' ) . '/webhook-' . $id . '.txt', json_encode( $request->all() ) );
	}
}
