<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsdMaterialRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csd_material_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->unique();
            $table->foreignId('unit_id')->nullable();
            $table->double('actual_rate');
            $table->double('demand_rate');
            $table->double('refund_rate');
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
        Schema::dropIfExists('csd_material_rates');
    }
}
