<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqMaterialPriceWastagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_material_price_wastages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nested_material_id')->nullable()->constrained('nested_materials')->nullOnDelete();
            $table->decimal('price')->nullable();
            $table->decimal('wastage')->nullable();
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
        Schema::dropIfExists('boq_material_price_wastages');
    }
}
