<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserTokenColumns extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table( 'user_tokens', function ( Blueprint $table ) {
			$table->dropColumn( [ 'currency_rate', 'currency_value' ] );
		} );

		Schema::table( 'user_tokens', function ( Blueprint $table ) {
			$table->bigInteger( 'currency_rate' )->default( 0 );
			$table->bigInteger( 'currency_value' )->default( 0 );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}
}
