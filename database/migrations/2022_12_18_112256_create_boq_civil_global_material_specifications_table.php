<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqCivilGlobalMaterialSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_civil_global_material_specifications', function (Blueprint $table) {
            $table->id();
            $table->string('item_head');
            $table->string('item_name');
            $table->integer('unit_id');
            $table->string('specification');
            $table->integer('unit_price');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('boq_civil_global_material_specifications');
    }
}