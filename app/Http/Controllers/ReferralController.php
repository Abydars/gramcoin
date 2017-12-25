<?php

namespace App\Http\Controllers;

use App\UserReferral;
use Illuminate\Http\Request;
use Dashboard;
use Datatables;
use Illuminate\Support\Facades\Auth;
use Referral;
use Option;

class ReferralController extends PanelController
{
	public function index()
	{
		$user = Auth::user();

		Dashboard::setTitle( 'Referral List' );

		$referrals   = Referral::getReferralToLevel( $user->id );
		$percentages = Option::getReferralPercentages();

		return view( 'referral.index', [
			'referrals'   => $referrals,
			'user'        => $user,
			'percentages' => $percentages
		] );
	}
}
