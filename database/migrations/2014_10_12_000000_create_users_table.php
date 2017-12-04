<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up()
	{
		Schema::create( 'users', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'avatar' )->default( '/img/avatar.svg' );
			$table->string( 'full_name' )->default( '' );
			$table->string( 'email' )->unique();
			$table->string( 'username' )->unique();
			$table->string( 'password' );
			$table->string( 'api_token', 60 )->unique()->nullable();
			$table->string( 'activated' )->default( false );
			$table->float( 'btc_balance', 20, 10 )->default( 0 );
			$table->string( 'guid' )->nullable();
			$table->longText( 'meta_data' )->nullable();
			$table->rememberToken();
			$table->timestamps();
		} );

		DB::table( 'users' )->insert(
			array(
				array(
					'id'             => 1,
					'full_name'      => 'Tester',
					'email'          => 'abidr.w@gmail.com',
					'username'       => 'tester',
					'password'       => bcrypt( 'tester' ),
					'api_token'      => null,
					'activated'      => '1',
					'remember_token' => 'o8fAByWQ9oXcg90HHcuRrZoTgsC2MfAX58jd7mnLzALIVPghyDzrxNOsNW9P',
					'created_at'     => Carbon::now()->toDateTimeString(),
					'updated_at'     => Carbon::now()->toDateTimeString(),
				)
			)
		);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::dropIfExists( 'users' );
	}
}
