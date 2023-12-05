<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsMaterialSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cs_material_suppliers', function (Blueprint $table)
        {
            $table->foreignId('cs_id')
                ->constrained('cs')
                ->cascadeOnDelete();
            $table->foreignId('cs_supplier_id')
                ->constrained('cs_suppliers', 'id')
                ->cascadeOnDelete();
            $table->foreignId('cs_material_id')
                ->constrained('cs_materials', 'id')
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
        Schema::dropIfExists('cs_material_suppliers');
    }
}
