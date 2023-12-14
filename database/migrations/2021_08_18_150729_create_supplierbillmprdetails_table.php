<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierbillmprdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplierbillmprdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('mpr_id');
            $table->unsignedBigInteger('supplierbill_id');
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
        Schema::dropIfExists('supplierbillmprdetails');
    }
}
