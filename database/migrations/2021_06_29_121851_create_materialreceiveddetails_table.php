<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialreceiveddetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materialreceiveddetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_receive_id');
            $table->foreign('material_receive_id')->on('material_receives')->references('id')->onDelete('cascade');
            $table->integer('material_id');
            $table->decimal('quantity', 20, 3);
            $table->string('brand')->nullable();
            $table->string('origin')->nullable();
            $table->integer('challan_no');
            $table->string('mrr_challan_key');
            $table->string('ledger_folio_no')->nullable();
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
        Schema::dropIfExists('materialreceiveddetails');
    }
}
