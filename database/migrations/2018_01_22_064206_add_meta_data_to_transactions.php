<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetaDataToTransactions extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table( 'transactions', function ( Blueprint $table ) {
			$table->longText( 'meta_data' )->nullable();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table( 'transactions', function ( Blueprint $table ) {
			$table->dropColumn( 'meta_data' );
		} );
	}
}
