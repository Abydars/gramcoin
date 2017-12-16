<?php

namespace App\Helpers;

use App;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class OptionsHelper
{
	public function getReferralPercentages()
	{
		return [
			50,
			40,
			30
		];
	}
}