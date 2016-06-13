<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('order_id');
            $table->string('customer_id');
            $table->string('product_id');
            $table->string('vehicle_id');
            $table->float('full_amount');
            $table->float('paid_amount');
            $table->boolean('isPaid');
            $table->boolean('isDelivered');
            $table->dateTime('delivered_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('orders');
    }
}
