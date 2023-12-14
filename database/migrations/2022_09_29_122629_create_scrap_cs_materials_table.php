<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapCsMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrap_cs_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scrap_cs_id')
                ->constrained('scrap_cs', 'id')
                ->cascadeOnDelete();
            $table->foreignId('material_id')
                ->constrained('nested_materials', 'id')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('scrap_form_id');
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
        Schema::dropIfExists('scrap_cs_materials');
    }
}
