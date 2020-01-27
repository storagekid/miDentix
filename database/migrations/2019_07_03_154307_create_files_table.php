<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('path', 255);
            $table->string('url', 255)->nullable();
            $table->string('type', 16);
            $table->string('thumbnail', 255)->nullable();
            $table->string('extension', 8);
            $table->char('permissions', 3)->default('740');
            $table->boolean('is_public')->default(0);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('fileable_id')->nullable();
            $table->string('fileable_type')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('group_id');
            $table->index('fileable_id');
            $table->index('fileable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
