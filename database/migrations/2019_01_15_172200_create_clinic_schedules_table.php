<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('clinic_profile_id');
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('job_type_id');
            $table->json('schedule')->nullable()->default(null);
            $table->timestamps();

            $table->unique(['clinic_profile_id','job_type_id']);
            $table->index('job_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_schedules');
    }
}
