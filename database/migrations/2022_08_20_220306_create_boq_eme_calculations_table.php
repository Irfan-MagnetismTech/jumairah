<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_calculations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->unsignedBigInteger('budget_head_id');
            $table->foreign('budget_head_id')->references('id')->on('eme_budget_heads')->onDelete('cascade');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('nested_materials')->onDelete('cascade');
            $table->unsignedBigInteger('boq_eme_rate_id');
            $table->foreign('boq_eme_rate_id')->references('id')->on('boq_eme_rates')->onDelete('cascade');
            $table->string('floor_id')->nullable();
            $table->unsignedBigInteger('material_id');
            $table->foreign('material_id')->references('id')->on('nested_materials')->onDelete('cascade');
            $table->integer('material_rate');
            $table->integer('labour_rate');
            $table->integer('quantity');
            $table->integer('total_material_amount');
            $table->integer('total_labour_amount')->nullable();
            $table->integer('total_amount');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('boq_eme_calculations');
    }
}
