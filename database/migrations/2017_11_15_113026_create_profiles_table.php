<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('name');
            $table->string('lastname1');
            $table->string('lastname2')->nullable();
            $table->string('personal_id_number')->nullable()->unique();
            $table->string('gender')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('hire_date')->nullable();
            $table->date('years_of_service')->nullable();
            $table->string('license_number')->nullable()->unique();
            $table->unsignedInteger('license_year')->nullable();
            $table->unsignedInteger('university_id')->nullable()->default(null);
            $table->unsignedInteger('tutorial_completed')->default(1);
            $table->string('avatar_path')->nullable()->default(null);

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
        Schema::dropIfExists('profiles');
    }
}
