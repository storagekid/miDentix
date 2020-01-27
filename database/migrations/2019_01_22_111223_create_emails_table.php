<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('type');
            $table->string('description')->nullable();
            $table->boolean('main')->default(false);
            $table->unsignedInteger('emailable_id');
            $table->string('emailable_type');
            $table->timestamps();

            $table->index('emailable_id');
            $table->index('emailable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
}
