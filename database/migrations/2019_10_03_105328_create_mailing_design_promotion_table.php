<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailingDesignPromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailing_design_promotion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('mailing_design_id');
            $table->unsignedInteger('promotion_id');
            $table->timestamps();

            $table->index('mailing_design_id');
            $table->index('promotion_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailing_design_promotion');
    }
}
