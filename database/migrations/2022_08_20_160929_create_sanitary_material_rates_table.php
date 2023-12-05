<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanitaryMaterialRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanitary_material_rates', function (Blueprint $table) {
            $table->id();
//            $table->integer('project_id');
//            $table->integer('parent_id_second')->nullable();
            $table->integer('material_id')->nullable();
//            $table->integer('quantity')->nullable();
            $table->integer('material_rate')->nullable();
//            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('sanitary_material_rates');
    }
}
