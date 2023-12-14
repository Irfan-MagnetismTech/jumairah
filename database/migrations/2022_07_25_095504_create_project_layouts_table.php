<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_layouts', function (Blueprint $table) {
            $table->id();
            $table->decimal('proposed_road_width', 20, 2)->nullable();
            $table->decimal('modified_far', 20, 2);
            $table->decimal('total_far', 20, 2);
            $table->decimal('proposed_mgc', 20, 2);
            $table->decimal('total_basement_floor');
            $table->decimal('front_verenda_feet', 20, 2);
            $table->decimal('grand_road_sft', 20, 2);
            $table->decimal('grand_far_sft', 20, 2);
            $table->string('proposed_story');
            $table->string('actual_story');
            $table->double('front_ver_spc_per');
            $table->double('front_verenda_percent');
            $table->double('percentage');
            $table->double('side_ver_spc_per');
            $table->unsignedBigInteger('bd_lead_location_id');
            $table->foreign('bd_lead_location_id')->on('bd_lead_generations')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('project_layouts');
    }
}
