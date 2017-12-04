<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserTransactionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'user_transactions', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( 'user_id' )->unsigned();
			$table->decimal( 'amount', 20, 10 )->default( 0 );
			$table->enum( 'currency', [ 'BTC', 'USD' ] );
			$table->enum( 'in_out', [ 'IN', 'OUT' ] );
			$table->longText( 'meta_data' )->nullable();
			$table->timestamps();

			$table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::disableForeignKeyConstraints();
		Schema::dropIfExists( 'user_transactions' );
	}
}
