<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperienceProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('experience_id');
            $table->unsignedInteger('profile_id');
            $table->timestamps();

            $table->unique(['experience_id','profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experience_profile');
    }
}
