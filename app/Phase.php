<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'tokens',
		'title',
		'launch_time',
		'status',
		'token_rate',
		'user_limit'
	];

	protected $table = 'phases';
	public $timestamps = false;

	protected $appends = [
		'bought_today',
		'bought',
		'is_open'
	];

	public function tokens()
	{
		return $this->hasMany( 'App\UserToken', 'phase_id', 'id' );
	}

	public function getBoughtTodayAttribute()
	{
		$tokens = UserToken::where( 'phase_id', $this->id )
		                   ->whereDate( 'created_at', '=', Carbon::now()->toDateString() )
		                   ->groupBy( 'phase_id' )
		                   ->sum( 'tokens' );

		return $tokens;
	}

	public function getBoughtAttribute()
	{
		$tokens = UserToken::where( 'phase_id', $this->id )
		                   ->groupBy( 'phase_id' )
		                   ->sum( 'tokens' );

		return $tokens;
	}

	public function getIsOpenAttribute()
	{
		if ( $this->status == 'active' ) {
			$launch_time = Carbon::parse( $this->launch_time );
			$diff        = Carbon::now()->diffInSeconds( $launch_time, false );

			return $diff < 0;
		}

		return false;
	}

	public static function getActivePhase()
	{
		$phases = Phase::where( 'status', 'active' )->orderBy( 'launch_time', 'asc' );

		return $phases->exists() ? $phases->first() : false;
	}

	public static function getInactivePhases()
	{
		$phases = Phase::where( 'status', 'inactive' )->orderBy( 'launch_time', 'asc' );

		return $phases->exists() ? $phases->get() : [];
	}

	public static function getPastPhases()
	{
		$phases = Phase::where( 'status', 'completed' )->orderBy( 'launch_time', 'asc' );

		return $phases->exists() ? $phases->get() : [];
	}
}
