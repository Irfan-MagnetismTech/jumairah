<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkCsSupplierRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_cs_supplier_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_cs_id')->constrained('work_cs', 'id')->cascadeOnDelete();
            $table->bigInteger('work_cs_supplier_id')->nullable(); 
            $table->bigInteger('work_cs_line_id')->nullable(); 
            $table->float('price')->nullable();
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
        Schema::dropIfExists('work_cs_supplier_rates');
    }
}
