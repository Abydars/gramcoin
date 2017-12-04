<?php

namespace App\Helpers;

use App;

class CurrencyHelper
{
	public function convertToSatoshi( $btc )
	{
		return $btc * 100000000;
	}
}