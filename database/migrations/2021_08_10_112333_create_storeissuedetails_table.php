<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreissuedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storeissuedetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('storeissue_id');
            $table->foreign('storeissue_id')->on('storeissues')->references('id')->onDelete('cascade');
            $table->foreignId('floor_id')->nullable();
            $table->foreignId('material_id');
            $table->string('ledger_folio_no');
            $table->integer('issued_quantity');
            $table->text('purpose');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('storeissuedetails');
    }
}
