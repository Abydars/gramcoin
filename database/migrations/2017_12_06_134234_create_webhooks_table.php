<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhooksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'webhooks', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'identifier' )->unique();
			$table->integer( 'wallet_id' )->unsigned();
			$table->string( 'url' );
			$table->dateTime( 'last_call' )->nullable();
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
		Schema::dropIfExists( 'webhooks' );
	}
}
