<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('nickname')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('email_ext')->nullable();
            $table->unsignedInteger('cost_center_id')->nullable();
            $table->unsignedInteger('county_id')->nullable();
            $table->unsignedInteger('language_id');
            $table->string('sanitary_code')->nullable();
            $table->unsignedInteger('clinic_manager_id')->nullable();
            $table->unsignedInteger('area_manager_id')->nullable();
            $table->unsignedInteger('clinic_cloud_id')->nullable();
            $table->string('oracle_id')->nullable();
            $table->unsignedInteger('closed')->default(0);
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('cost_center_id');
            $table->index('county_id');
            $table->index('language_id');
            $table->index('clinic_manager_id');
            $table->index('area_manager_id');
            $table->index('clinic_cloud_id');
            $table->index('oracle_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stands');
    }
}
