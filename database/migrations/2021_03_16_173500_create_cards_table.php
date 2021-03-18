<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('card_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('nomenclature_id');
            $table->unsignedInteger('quantity')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('nomenclature_id')->on('nomenclatures')->references('nomenclature_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropForeign('cards_user_id_foreign');
            $table->dropForeign('cards_nomenclature_id_foreign');
            $table->drop();
        });
    }
}
