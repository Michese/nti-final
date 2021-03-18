<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargos', function (Blueprint $table) {
            $table->bigIncrements('cargo_id');
            $table->unsignedBigInteger('nomenclature_id');
            $table->string('barcode')->unique();
            $table->unsignedDouble('weight')->nullable(false);
            $table->timestamps();
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
        Schema::table('cargos', function (Blueprint $table) {
            $table->dropForeign('cargos_nomenclature_id_foreign');
            $table->drop();
        });
    }
}
