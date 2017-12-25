<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhaseIdToUserTokensTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table( 'user_tokens', function ( Blueprint $table ) {
			$table->integer( 'phase_id' );
			$table->foreign( 'phase_id' )->references( 'id' )->on( 'phases' )->onDelete( 'cascade' );
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
			$table->dropForeign( [ 'phase_id' ] );
			$table->dropColumn( 'phase_id' );
		} );
	}
}
