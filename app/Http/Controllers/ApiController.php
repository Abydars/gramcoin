<?php

namespace App\Http\Controllers;

use App\Phase;
use App\UserToken;
use Illuminate\Http\Request;
use Currency;

class ApiController extends Controller
{
	public function tokens_info()
	{
		$sold_tokens = UserToken::getTotalSoldTokens();
		$tokens      = Phase::getTotalTokens();

		return response()->json( [
			                         'status' => 200,
			                         'data'   => [
				                         'total' => $tokens,
				                         'sold'  => $sold_tokens
			                         ]
		                         ] );
	}

	public function rates()
	{
		$btc_value  = Currency::getBtcValue();
		$token_rate = Currency::getTokenValue();

		return response()->json( [
			                         'status' => 200,
			                         'data'   => [
				                         'btc' => $btc_value,
				                         'grm' => $token_rate
			                         ]
		                         ] );
	}
}
