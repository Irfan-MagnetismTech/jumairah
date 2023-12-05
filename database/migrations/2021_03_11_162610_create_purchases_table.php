<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id')->nullable();
            $table->integer('section_id')->nullable();
            $table->integer('purchase_order_id')->nullable();
            $table->string('purchase_type')->nullable();
            $table->string('lc_type')->nullable();
            $table->string('LC_number')->nullable();
            $table->date('lc_opening_date')->nullable();
            $table->date('date')->nullable();
            $table->date('lc_receiving_date')->nullable();
            $table->integer('warehouse_id')->default(1);
            $table->integer('issue_bank')->nullable();
            $table->integer('advising_bank')->nullable();
            $table->integer('negotiate_bank')->nullable();
            $table->decimal('total_amount','10')->nullable();
            $table->decimal('lc_amount','10')->nullable();
            $table->decimal('tt_amount','10')->nullable();
            $table->decimal('lc_weight','10')->nullable();
            $table->decimal('bl_weight','10')->nullable();
            $table->decimal('receiving_weight','10')->nullable();
            $table->decimal('vat','10')->nullable();
            $table->decimal('discount','10')->nullable();
            $table->string('remarks')->nullable();
            $table->string('invoice_img')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
