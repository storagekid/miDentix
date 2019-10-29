<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('v_design_file_id')->nullable();
            $table->unsignedInteger('h_design_file_id')->nullable();
            $table->json('v_design_index_coords')->nullable();
            $table->json('h_design_index_coords')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
