<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeCsSupplierOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_cs_supplier_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boq_eme_cs_supplier_id')
                ->constrained('boq_eme_cs_suppliers')
                ->cascadeOnDelete();
            $table->foreignId('boq_eme_cs_supplier_eval_field_id')
            ->constrained('boq_eme_cs_supplier_eval_fields')
            ->cascadeOnDelete();
            $table->string('value');
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
        Schema::dropIfExists('boq_eme_cs_supplier_options');
    }
}
