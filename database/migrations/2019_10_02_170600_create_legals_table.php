<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->text('text');
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('county_id')->nullable();
            $table->unsignedInteger('clinic_id')->nullable();
            $table->unsignedInteger('legalizable_id');
            $table->string('legalizable_type');
            $table->timestamps();
            $table->softDeletes();

            $table->index('language_id');
            $table->index('country_id');
            $table->index('state_id');
            $table->index('county_id');
            $table->index('clinic_id');
            $table->index('legalizable_id');
            $table->index('legalizable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legals');
    }
}
