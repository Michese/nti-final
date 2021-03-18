<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            $table->string('document')->unique();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedInteger('status_id')->default(1);
            $table->timestamp('completion')->nullable(true)->default(null);
            $table->timestamps();
            $table->foreign('client_id')->on('users')->references('id');
            $table->foreign('driver_id')->on('users')->references('id');
            $table->foreign('status_id')->on('statuses')->references('status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_client_id_foreign');
            $table->dropForeign('orders_driver_id_foreign');
            $table->dropForeign('orders_status_id_foreign');
            $table->drop();
        });
    }
}
