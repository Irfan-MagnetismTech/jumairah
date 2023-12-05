<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cs_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('collection_way')->nullable();
            $table->foreignId('cs_id')->constrained('cs', 'id')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers', 'id')->cascadeOnDelete();
            $table->string('grade', 255);
            $table->string('vat_tax', 255);
            $table->string('tax', 255);
            $table->string('credit_period', 255);
            $table->string('material_availability', 255);
            $table->string('delivery_condition', 255);
            $table->string('required_time', 255);
            $table->boolean('is_checked')->default(false);
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
        Schema::dropIfExists('cs_suppliers');
    }
}
