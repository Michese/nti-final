<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargoOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargo_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('cargo_id')->unique();
            $table->boolean('hasShip')->default(false);
            $table->timestamps();
            $table->foreign('order_id')->on('orders')->references('order_id');
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
        Schema::table('cargo_orders', function (Blueprint $table) {
            $table->dropForeign('cargo_orders_order_id_foreign');
            $table->dropForeign('cargo_orders_cargo_id_foreign');
            $table->drop();
        });
    }
}
