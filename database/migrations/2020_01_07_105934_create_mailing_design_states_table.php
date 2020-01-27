<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailingDesignStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailing_design_states', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mailing_design_id');
            $table->unsignedBigInteger('state_id');
            $table->timestamps();

            $table->index('mailing_design_id');
            $table->index('state_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailing_design_states');
    }
}
