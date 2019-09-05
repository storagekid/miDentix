<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicPostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_posters', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('clinic_id');
            $table->unsignedInteger('poster_id');
            $table->string('type');
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            // $table->integer('qty')->nullable(); // SHOULD BE DELETE
            // $table->integer('priority')->nullable(); // SHOULD BE DELETE
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
        Schema::dropIfExists('clinic_posters');
    }
}
