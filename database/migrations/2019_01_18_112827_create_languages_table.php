<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('iso_name');
            $table->string('native_name')->nullable()->default(null);
            $table->string('639-1')->nullable()->default(null);
            $table->string('639-2/T')->nullable()->default(null);
            $table->string('639-2/B')->nullable()->default(null);
            $table->string('639-3')->nullable()->default(null);
            $table->string('notes')->nullable()->default(null);
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
        Schema::dropIfExists('languages');
    }
}
