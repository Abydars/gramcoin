<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'wallets', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'identity' )->unique();
			$table->string( 'name' );
			$table->string( 'pass' );
			$table->text( 'primary_mnemonic' );
			$table->text( 'backup_mnemonic' )->nullable();
			$table->text( 'blocktrail_keys' )->nullable();
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists( 'wallets' );
	}
}
