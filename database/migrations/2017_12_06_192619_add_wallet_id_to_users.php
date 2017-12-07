<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWalletIdToUsers extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table( 'users', function ( Blueprint $table ) {
			$table->integer( 'wallet_id' )->unsigned()->nullable();
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
		Schema::table( 'users', function ( Blueprint $table ) {
			$table->dropForeign( [ 'wallet_id' ] );
			$table->dropColumn( 'wallet_id' );
		} );
	}
}
