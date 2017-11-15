<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspecialtyProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialty_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('especialty_id');
            $table->unsignedInteger('profile_id');
            $table->timestamps();

            $table->unique(['especialty_id','profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('especialty_profile');
    }
}
