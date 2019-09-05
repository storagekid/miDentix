<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignPostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_posters', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('poster_id');
            $table->unsignedInteger('poster_model_id');
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('county_id')->nullable();
            $table->unsignedInteger('clinic_id')->nullable();
            $table->unsignedInteger('poster_af_file_id')->nullable();
            $table->string('type', 16);
            // $table->string('file');
            // $table->string('link');
            // $table->string('thumbnail');
            $table->timestamps();

            $table->unique(['campaign_id','poster_id','poster_model_id','language_id','country_id','state_id','county_id','clinic_id','type'], 'campaign_poster_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_posters');
    }
}
