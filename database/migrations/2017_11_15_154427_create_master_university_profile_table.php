<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterUniversityProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_university_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('master_university_id');
            $table->unsignedInteger('profile_id');
            $table->timestamps();

            $table->unique(['master_university_id','profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_university_profile');
    }
}
