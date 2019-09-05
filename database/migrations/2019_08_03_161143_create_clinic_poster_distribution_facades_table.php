<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicPosterDistributionFacadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_poster_distribution_facades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('clinic_poster_distribution_id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('complete_facade_file_id')->nullable();
            $table->timestamps();

            $table->unique(['clinic_poster_distribution_id','campaign_id'], 'campaign_facade_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_poster_distribution_facades');
    }
}
