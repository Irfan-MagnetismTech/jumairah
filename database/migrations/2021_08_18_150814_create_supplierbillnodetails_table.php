<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierbillnodetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplierbillnodetails', function (Blueprint $table) {
            $table->id();
            $table->integer('bill_no');
            $table->decimal('amount',18,2);
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
        Schema::dropIfExists('supplierbillnodetails');
    }
}
