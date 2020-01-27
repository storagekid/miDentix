<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicSiblingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_siblings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('sibling_id');
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->string('type');
            $table->softDeletes();
            $table->timestamps();

            $table->index('clinic_id');
            $table->index('sibling_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_siblings');
    }
}
