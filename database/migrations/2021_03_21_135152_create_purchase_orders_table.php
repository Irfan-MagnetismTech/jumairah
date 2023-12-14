<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('mpr_no');
            $table->string('po_no', 50)->default(1);
            $table->integer('cs_id');
            $table->integer('supplier_id');
            $table->decimal('final_total','10');
            $table->unsignedBigInteger('applied_by');
            $table->decimal('carrying_charge','10')->nullable();
            $table->decimal('labour_charge','10')->nullable();
            $table->decimal('discount','10')->nullable();
            $table->string('source_tax');
            $table->string('source_vat');
            $table->string('carrying');
            $table->string('receiver_name')->nullable();
            $table->string('receiver_contact')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
}
