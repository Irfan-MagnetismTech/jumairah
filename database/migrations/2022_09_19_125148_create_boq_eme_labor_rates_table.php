<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeLaborRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_labor_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('second_layer_parent_id')->nullable();
            $table->unsignedBigInteger('project_id');
            $table->longText('note');
            $table->longText('description');
            $table->longText('basis_of_measurement');
            $table->integer('type')->default(0)->comment('0=>material_rate,1=>work_rate');
            $table->unsignedBigInteger('applied_by');
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
        Schema::dropIfExists('boq_eme_labor_rates');
    }
}
