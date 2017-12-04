<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserTokensTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'user_tokens', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( 'user_id' )->unsigned();
			$table->integer( 'tokens' )->default( 0 );
			$table->decimal( 'token_rate', 20, 10 )->default( 0 );
			$table->enum( 'currency', [ 'BTC', 'USD' ] );
			$table->decimal( 'currency_rate', 20, 10 );
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
		Schema::dropIfExists( 'user_tokens' );
	}
}
