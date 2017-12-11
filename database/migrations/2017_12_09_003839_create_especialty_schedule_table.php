<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspecialtyScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialty_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('especialty_id');
            $table->unsignedInteger('schedule_id');
            $table->timestamps();

            $table->unique(['especialty_id','schedule_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('especialty_schedule');
    }
}
