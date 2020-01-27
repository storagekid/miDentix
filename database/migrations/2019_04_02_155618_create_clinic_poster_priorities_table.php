<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicPosterPrioritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_poster_priorities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('campaign_id')->nullable();
            $table->unsignedInteger('clinic_poster_id');
            $table->unsignedInteger('priority');
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->timestamps();

            $table->index('campaign_id');
            $table->index('clinic_poster_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_poster_priorities');
    }
}
