<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdLeadGenerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_lead_generations', function (Blueprint $table) {
            $table->id();
            $table->integer('entry_by');
            $table->string('land_under');
            $table->string('lead_stage');
            $table->string('project_category');
            $table->string('category');
            $table->string('land_status');
            $table->integer('source_id');
            $table->integer('division_id');
            $table->integer('district_id');
            $table->integer('thana_id');
            $table->string('mouza_id');
            $table->integer('basement');
            $table->integer('storey')->nullable();
            $table->decimal('land_size', 20,2);
            $table->decimal('front_road_size', 20,2);
            $table->decimal('side_road_size', 20,2)->nullable();
            $table->decimal('surrendered_land', 20,2)->default(0);
            $table->decimal('proposed_front_road_size', 20,2)->default(0);
            $table->decimal('proposed_side_road_size', 20,2)->default(0);
            $table->string('land_location');
            $table->string('remarks')->nullable();
            $table->string('status');
            $table->string('survey_report', 255)->nullable();
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
        Schema::dropIfExists('bd_lead_generations');
    }
}
