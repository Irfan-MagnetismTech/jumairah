<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id_second')->nullable();
            $table->integer('material_id')->nullable();
            $table->integer('boq_work_id')->nullable();
            $table->integer('type')->default(0)->comment('0=>material_rate,1=>work_rate');
            $table->integer('labour_rate')->nullable();
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
        Schema::dropIfExists('boq_eme_rates');
    }
}
