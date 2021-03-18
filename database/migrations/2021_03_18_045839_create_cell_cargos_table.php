<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCellCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cell_cargos', function (Blueprint $table) {
            $table->bigIncrements('cell_cargo_id');
            $table->unsignedBigInteger('cell_id');
            $table->unsignedBigInteger('cargo_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('cell_id')->on('cells')->references('cell_id');
            $table->foreign('cargo_id')->on('cargos')->references('cargo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cell_cargos', function (Blueprint $table) {
            $table->dropForeign('cell_cargos_cell_id_foreign');
            $table->dropForeign('cell_cargos_cargo_id_foreign');
            $table->drop();
        });
    }
}
