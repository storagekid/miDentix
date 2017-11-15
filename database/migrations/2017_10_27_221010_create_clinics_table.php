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
            $table->string('city')->nullable();
            $table->string('address_real_1')->nullable();
            $table->string('address_real_2')->nullable();
            $table->string('address_adv_1')->nullable();
            $table->string('address_adv_2')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone_real')->nullable();
            $table->string('phone_adv')->nullable();
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
