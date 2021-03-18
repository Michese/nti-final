<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueueWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_warehouses', function (Blueprint $table) {
            $table->bigIncrements('queue_warehouse_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')->on('warehouses')->references('warehouse_id');
            $table->foreign('order_id')->on('orders')->references('order_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('queue_warehouses', function (Blueprint $table) {
            $table->dropForeign('queue_warehouses_warehouse_id_foreign');
            $table->dropForeign('queue_warehouses_order_id_foreign');
            $table->drop();
        });
    }
}
