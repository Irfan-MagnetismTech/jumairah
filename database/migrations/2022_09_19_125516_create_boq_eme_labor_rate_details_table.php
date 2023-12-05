<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeLaborRateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_labor_rate_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boq_eme_labor_rate_id');
            $table->foreign('boq_eme_labor_rate_id')->on('boq_eme_labor_rates')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('material_id')->nullable();
            $table->unsignedBigInteger('boq_work_id')->nullable();
            $table->decimal('labor_rate',8,4);
            $table->decimal('qty',8,4);
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
        Schema::dropIfExists('boq_eme_labor_rate_details');
    }
}
