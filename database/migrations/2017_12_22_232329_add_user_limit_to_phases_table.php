<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserLimitToPhasesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table( 'phases', function ( Blueprint $table ) {
			$table->integer( 'user_limit' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table( 'phases', function ( Blueprint $table ) {
			$table->dropColumn( [ 'user_limit' ] );
		} );
	}
}
