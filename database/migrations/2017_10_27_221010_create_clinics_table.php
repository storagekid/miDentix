<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('city');
            $table->string('address_real_1');
            $table->string('address_real_2');
            $table->string('address_adv_1');
            $table->string('address_adv_2');
            $table->string('postal_code');
            $table->string('phone_real');
            $table->string('phone_adv');
            $table->string('email_ext')->unique()->nullable();
            $table->string('sanitary_code')->nullable();
            $table->string('provincia_id');
            $table->string('clinic-cloud_id')->nullable();
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
        Schema::dropIfExists('clinics');
    }
}
