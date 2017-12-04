<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create( 'referrals', function ( Blueprint $table ) {
		    $table->increments( 'id' );
		    $table->integer( 'user_id' )->unsigned();
		    $table->integer( 'referred_by' )->unsigned();

		    $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
		    $table->foreign( 'referred_by' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::disableForeignKeyConstraints();
	    Schema::dropIfExists( 'referrals' );
    }
}
