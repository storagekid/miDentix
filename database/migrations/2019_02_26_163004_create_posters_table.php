<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('width'); // mm (700)
            $table->string('height'); // mm (1000)
            $table->string('name'); // ex (70x100)
            $table->string('description')->nullable()->default(null); // ex (70x100 Translight)
            $table->string('material'); // ex (70x100 Translight)
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
        Schema::dropIfExists('posters');
    }
}
