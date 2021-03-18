<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->integerIncrements('transport_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedDouble('capacity')->nullable(false);
            $table->unsignedDouble('occupancy')->default(0);
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transports', function (Blueprint $table) {
            $table->dropForeign('transports_user_id_foreign');
            $table->drop();
        });
    }
}
