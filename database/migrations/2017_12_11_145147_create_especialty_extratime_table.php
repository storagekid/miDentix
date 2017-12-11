<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspecialtyExtratimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialty_extratime', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('especialty_id');
            $table->unsignedInteger('extratime_id');
            $table->timestamps();

            $table->unique(['especialty_id','extratime_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('especialty_extratime');
    }
}
