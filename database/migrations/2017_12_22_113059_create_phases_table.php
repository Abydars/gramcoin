<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhasesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'phases', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( 'tokens' )->default( 0 );
			$table->string( 'title' );
			$table->dateTime( 'launch_time' );
			$table->decimal( 'token_rate', 20, 10 )->default( 0 );
			$table->enum( 'status', [ 'inactive', 'active', 'completed' ] )->default( 'inactive' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists( 'phases' );
	}
}
