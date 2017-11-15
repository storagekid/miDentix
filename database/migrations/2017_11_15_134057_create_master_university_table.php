<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterUniversityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_university', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('master_id');
            $table->unsignedInteger('university_id');
            $table->timestamps();

            $table->unique(['master_id','university_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_university');
    }
}
