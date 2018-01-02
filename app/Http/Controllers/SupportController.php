<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dashboard;

class SupportController extends PanelController
{
	public function index()
	{
		Dashboard::setTitle( 'Support' );

		return view( 'support.index' );
	}
}
