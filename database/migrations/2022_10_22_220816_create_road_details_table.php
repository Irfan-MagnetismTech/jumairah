<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoadDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('road_details', function (Blueprint $table) {
            $table->unsignedBigInteger('project_layout_id');
            $table->foreign('project_layout_id')->on('project_layouts')->references('id')->onDelete('cascade');
            $table->decimal('proposed_road', 20, 2)->nullable();
            $table->decimal('existing_road', 20, 2)->nullable();
            $table->decimal('road_width', 20, 2)->nullable();
            $table->decimal('land_width', 20, 2)->nullable();
            $table->decimal('additional_far', 20, 2)->nullable();
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
        Schema::dropIfExists('road_details');
    }
}
