<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningRawMaterialDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opening_raw_material_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opening_material_id');
            $table->foreign('opening_material_id')->on('opening_raw_materials')->references('id')->onDelete('cascade');
            $table->integer('material_id');
            $table->integer('quantity');
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
        Schema::dropIfExists('opening_raw_material_details');
    }
}
