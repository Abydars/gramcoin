<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyValueToUserTokens extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table( 'user_tokens', function ( Blueprint $table ) {
			$table->decimal( 'currency_value', 20, 10 );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table( 'user_tokens', function ( Blueprint $table ) {
			$table->dropColumn( 'currency_value' );
		} );
	}
}
