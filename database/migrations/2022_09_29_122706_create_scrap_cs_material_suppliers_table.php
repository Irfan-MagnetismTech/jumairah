<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapCsMaterialSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrap_cs_material_suppliers', function (Blueprint $table) {
            $table->foreignId('scrap_cs_id')
            ->constrained('scrap_cs')
            ->cascadeOnDelete();
        $table->foreignId('scrap_cs_supplier_id')
            ->constrained('scrap_cs_suppliers', 'id')
            ->cascadeOnDelete();
        $table->foreignId('scrap_cs_material_id')
            ->constrained('scrap_cs_materials', 'id')
            ->cascadeOnDelete();
        $table->decimal('price', 20, 2);
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
        Schema::dropIfExists('scrap_cs_material_suppliers');
    }
}