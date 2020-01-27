<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicMailingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_mailings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('mailing_design_id');
            $table->unsignedInteger('clinic_id');
            $table->unsignedInteger('clinic_af_file_id')->nullable();
            $table->unsignedInteger('printer_id')->nullable();
            $table->unsignedInteger('printer_product_id')->nullable();
            $table->integer('printed_qty')->nullable();
            $table->unsignedInteger('distributor_id')->nullable();
            $table->unsignedInteger('distributor_service_id')->nullable();
            $table->integer('distributed_stand_qty')->nullable();
            $table->integer('distributed_doordrop_qty')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('mailing_design_id');
            $table->index('clinic_id');
            $table->index('clinic_af_file_id');
            $table->index('printer_id');
            $table->index('printer_product_id');
            $table->index('distributor_id');
            $table->index('distributor_service_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_mailings');
    }
}
