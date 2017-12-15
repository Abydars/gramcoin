<?php

namespace App\Helpers;

use App;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class OptionsHelper
{
	public function getAdminWalletAddress()
	{
		if ( env( 'APP_ENV' ) == 'local' ) {
			return "2N6Fo7ZiTBZ7gT7FX1PHN923xXHuVoE9kLk";
		} else {
			return "";
		}
	}
}