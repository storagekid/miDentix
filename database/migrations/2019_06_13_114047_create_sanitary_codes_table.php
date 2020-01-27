<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSanitaryCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanitary_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('description')->nullable();
            $table->unsignedInteger('clinic_id')->nullable();
            $table->unsignedInteger('county_id')->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('campaign_id')->nullable();
            $table->unsignedInteger('sanitizable_id');
            $table->string('sanitizable_type');
            $table->timestamps();

            $table->index('clinic_id');
            $table->index('county_id');
            $table->index('state_id');
            $table->index('country_id');
            $table->index('campaign_id');
            $table->index('sanitizable_id');
            $table->index('sanitizable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sanitary_codes');
    }
}
