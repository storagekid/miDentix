<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('street_type_id')->nullable()->default(null);
            // $table->string('street_name')->nullable()->default(null);
            // $table->string('number')->nullable()->default(null);
            // $table->string('building')->nullable()->default(null);
            // $table->string('stair')->nullable()->default(null);
            // $table->string('floor')->nullable()->default(null);
            // $table->string('door')->nullable()->default(null);
            // $table->string('street_detail')->nullable()->default(null);
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            // $table->string('full_address')->nullable();
            $table->string('type');
            $table->string('description')->nullable();
            $table->boolean('main')->default(0);
            $table->unsignedInteger('addressable_id');
            $table->string('addressable_type');
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
        Schema::dropIfExists('addresses');
    }
}
