<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'bonuses', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->unsignedInteger( 'awarded_to' );
			$table->unsignedInteger( 'purchase_id' );
			$table->integer( 'amount' )->default( 0 );
			$table->decimal( 'rate', 20, 10 )->default( 0 );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Schema::disableForeignKeyConstraints();
		Schema::dropIfExists( 'bonuses' );
	}
}
