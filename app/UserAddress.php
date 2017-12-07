<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
	protected $table = 'addresses';

	public $timestamps = false;

	protected $fillable = [
		'address',
		'user_id',
		'is_used'
	];

	public function user()
	{
		return $this->belongsTo( 'App\User' );
	}
}
