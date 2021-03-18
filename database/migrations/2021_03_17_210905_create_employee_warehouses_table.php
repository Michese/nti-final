<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_warehouses', function (Blueprint $table) {
            $table->bigIncrements('employee_warehouse_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->timestamps();
            $table->foreign('warehouse_id')->on('warehouses')->references('warehouse_id');
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
        Schema::table('employee_warehouses', function (Blueprint $table) {
            $table->dropForeign('employee_warehouses_warehouse_id_foreign');
            $table->dropForeign('employee_warehouses_user_id_foreign');
            $table->drop();
        });
    }
}
