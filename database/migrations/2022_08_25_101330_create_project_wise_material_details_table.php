<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectWiseMaterialDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_wise_material_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_wise_material_id')->nullable();
            $table->integer('material_id')->nullable();
            $table->string('rate_type')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('material_rate')->nullable();
            $table->timestamps();
            $table->foreign('project_wise_material_id')->references('id')->on('project_wise_materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_wise_material_details');
    }
}
