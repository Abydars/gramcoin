<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class DashboardHelper
{
	private $active_navigation;
	private $navigations;
	private $user;
	private $title;

	public function __construct()
	{
		$user        = Auth::user();
		$navigations = Config::get( 'constants.navigations' );

		$this->navigations = $navigations;
		$this->user        = $user;
		$this->config_active_navigation();
	}

	private function config_active_navigation()
	{
		$path  = Request::path();
		$queue = array_reverse( $this->navigations );
		do {
			$navigation = array_shift( $queue );
			if ( $navigation['item_type'] == 'item' && strpos( $path, $navigation['action'] ) === 0 ) {
				$this->active_navigation = $navigation;
				$this->title             = $navigation['label'];

				return;
			}

			if ( isset( $navigation['children'] ) ) {
				$navigation['children'] = array_reverse( $navigation['children'] );
				$queue                  = array_merge( $queue, $navigation['children'] );
			}
		} while ( ! empty( $queue ) );
		//$this->active_navigation = false;
	}

	public function active_navigation()
	{
		return $this->active_navigation;
	}

	public function setTitle( $title )
	{
		$this->title = $title;
	}

	public function title()
	{
		return ( empty( $this->title ) ) ? Config::get( 'app.name' ) : $this->title;
	}

	public function navigations()
	{
		return $this->navigations;
	}

	public function user()
	{
		return $this->user;
	}
}
