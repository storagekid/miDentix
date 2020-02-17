<?php

use Illuminate\Support\Facades\Schema;
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
            $table->increments('id');
            $table->unsignedInteger('shopping_bag_id');
            $table->unsignedInteger('user_id'); // User that makes the Order
            $table->unsignedInteger('clinic_id');
            $table->unsignedInteger('provider_id');
            $table->unsignedInteger('profile_id')->nullable();
            $table->string('details')->nullable();
            $table->unsignedInteger('orderable_id');
            $table->string('orderable_type');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('priority')->default(3); // (1) Urgent, (2) Preferred, (3) Normal
            $table->unsignedInteger('state')->default(1); // (1) Placed, (2) Recieve, (3) Production, (4) Sent, (5) Delivered, (6) Canceled
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
        Schema::dropIfExists('orders');
    }
}
