<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtratimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extratimes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('clinic_id')->nullable();
            $table->unsignedInteger('profile_id');
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('provincia_id')->nullable();
            $table->text('schedule');
            $table->unsignedInteger('state')->default(1); // Pendiente
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
        Schema::dropIfExists('extratimes');
    }
}
