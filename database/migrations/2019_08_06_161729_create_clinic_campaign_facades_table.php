<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicCampaignFacadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_campaign_facades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('facades_file_id');
            $table->timestamps();

            $table->unique(['clinic_id','campaign_id'], 'campaign_facades_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_campaign_facades');
    }
}
