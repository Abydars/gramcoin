<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'transactions', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'tx_hash' );
			$table->string( 'recipient' )->nullable();
			$table->string( 'direction' );
			$table->integer( 'amount' );
			$table->integer( 'confirmations' );
			$table->integer( 'wallet_id' )->unsigned();
			$table->datetime( 'tx_time' );
			$table->timestamps();

			$table->foreign( 'wallet_id' )->references( 'id' )->on( 'wallets' )->onDelete( 'cascade' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists( 'transactions' );
	}
}
