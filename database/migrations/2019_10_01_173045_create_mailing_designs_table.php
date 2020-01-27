<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailingDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailing_designs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('type', 16);
            $table->unsignedInteger('mailing_id');
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('county_id')->nullable();
            $table->unsignedInteger('clinic_id')->nullable();
            $table->unsignedInteger('base_af_file_id')->nullable();
            $table->timestamps();

            $table->index('mailing_id');
            $table->index('language_id');
            $table->index('country_id');
            $table->index('state_id');
            $table->index('county_id');
            $table->index('clinic_id');
            $table->index('base_af_file_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailing_designs');
    }
}
