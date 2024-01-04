<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierbillofficebilldetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplierbillofficebilldetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplierbill_id');
            $table->integer('mrr_no');
            $table->string('po_no',100);
            $table->integer('mpr_no');
            $table->foreignId('supplier_id')->nullable();
            $table->integer('amount');
            $table->string('remarks', 250);
            $table->foreign('supplierbill_id')->on('supplierbills')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('supplierbillofficebilldetails');
    }
}
