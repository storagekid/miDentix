<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('provider_id');
            $table->string('description')->nullable();
            $table->decimal('price', 26, 16)->nullable();
            $table->unsignedInteger('min_quantity')->default(1);
            $table->unsignedInteger('max_quantity')->nullable()->default(1000000);
            $table->unsignedInteger('default_quantity')->default(1);
            $table->unsignedInteger('quantity_steps')->default(1);
            $table->unsignedInteger('delivery_time')->default(7); // days
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->string('details')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('county_id')->nullable();
            $table->unsignedInteger('clinic_id')->nullable();
            $table->unsignedInteger('store_id')->nullable();
            $table->timestamps();

            $table->index('product_id');
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
        Schema::dropIfExists('product_providers');
    }
}
