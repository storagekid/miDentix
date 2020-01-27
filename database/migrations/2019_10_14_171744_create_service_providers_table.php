<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_id');
            $table->unsignedInteger('provider_id');
            $table->string('description');
            $table->decimal('price', 16, 6);
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->string('details')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('county_id')->nullable();
            $table->unsignedInteger('clinic_id')->nullable();
            $table->unsignedInteger('store_id')->nullable();
            $table->timestamps();

            $table->index('service_id');
            $table->index('provider_id');
            $table->index('country_id');
            $table->index('state_id');
            $table->index('county_id');
            $table->index('clinic_id');
            $table->index('store_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_providers');
    }
}
