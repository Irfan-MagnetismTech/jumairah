<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeCsMaterialSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_cs_material_suppliers', function (Blueprint $table) {
            $table->foreignId('boq_eme_cs_id')
                ->constrained('boq_eme_cs')
                ->cascadeOnDelete();
            $table->foreignId('boq_eme_cs_supplier_id')
                ->constrained('boq_eme_cs_suppliers', 'id')
                ->cascadeOnDelete();
            $table->foreignId('boq_eme_cs_material_id')
                ->constrained('boq_eme_cs_materials', 'id')
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
        Schema::dropIfExists('boq_eme_cs_material_suppliers');
    }
}
