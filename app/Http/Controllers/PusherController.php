<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SebastianBergmann\RecursionContext\Context;
use Vinkla\Pusher\Facades\Pusher;

class PusherController extends PanelController
{
    public function auth(Request $request)
    {
        //$pusher = new Pusher(env('PUSHER_KEY'), env('PUSHER_KEY'), env('PUSHER_APP_ID'));
        //$user = Context::get('User')->model();
        $user = Auth::user();

        $socket  = $request->input('socket_id');
        $channel = $request->input('channel_name');
        $account = $request->input('account_id');

        $response = Pusher::auth($user, $account, $channel, $socket)->authenticate();

        return response($response, 200)->header('Content-Type', 'application/json');
    }
}
