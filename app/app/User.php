<?php

namespace App;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Config;
use \App\Facades\UtilsFacade;
use \App\UserGoal;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'full_name',
		'username',
		'email',
		'password',
		'avatar',
		'activated'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	public function user_goals()
	{
		return $this->hasMany( 'App\UserGoal', 'user_id' )->orderBy( 'season_start_at' );
	}

	public function user_season_goal()
	{
		$current_season = UtilsFacade::currentSeason();
		$user_goal      = UserGoal::where( [
			                                   'season_start_at' => $current_season['start_at'],
			                                   'user_id'         => $this->id
		                                   ] )->first();

		return $user_goal;
	}

	public function getNameAttribute()
	{
		return "{$this->firstname} {$this->lastname}";
	}

	public function setActivatedAttribute( $value )
	{
		$this->attributes['activated'] = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
	}

	public function getActivatedAttribute()
	{
		if ( ! isset( $this->attributes['activated'] ) ) {
			return true;
		}

		if ( $this->attributes['activated'] == true ) {
			return true;
		}

		return false;
	}

	public function isSalesManager()
	{
		$user_roles = Config::get( "constants.users.user_roles" );

		return $this->attributes['user_role'] == $user_roles['manager'];
	}

	/**
	 * The channels the user receives notification broadcasts on.
	 *
	 * @return string
	 */
	public function receivesBroadcastNotificationsOn()
	{
		return 'user.' . $this->id;
	}
}
