<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
	protected $table = 'bonuses';
	protected $fillable = [
		'awarded_to',
		'purchase_id',
		'amount',
		'rate'
	];

	public function user()
	{
		return $this->belongsTo( 'App\User', 'awarded_to', 'id' );
	}

	public function token()
	{
		return $this->belongsTo( 'App\UserToken', 'purchase_id', 'id' );
	}
}
