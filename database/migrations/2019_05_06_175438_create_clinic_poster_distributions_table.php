<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicPosterDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_poster_distributions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('clinic_id');
            $table->unsignedInteger('address_id');
            $table->unsignedInteger('campaign_id')->nullable();
            $table->unsignedInteger('original_facade_file_id')->nullable();
            $table->unsignedInteger('composed_facade_file_id')->nullable();
            $table->unsignedInteger('complete_facade_file_id')->nullable(); // Should be deleted
            // $table->string('facade');
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->json('distributions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_poster_distributions');
    }
}
