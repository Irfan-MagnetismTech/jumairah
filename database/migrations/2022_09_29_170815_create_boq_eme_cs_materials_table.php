<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeCsMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_cs_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boq_eme_cs_id')
                ->constrained('boq_eme_cs', 'id')
                ->cascadeOnDelete();
            $table->foreignId('material_id')
                ->constrained('nested_materials', 'id')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('boq_eme_cs_materials');
    }
}
