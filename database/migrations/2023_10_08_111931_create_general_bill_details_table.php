<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralBillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_bill_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('general_bill_id');
            $table->foreign('general_bill_id')->on('general_bills')->references('id')->onDelete('cascade');
            $table->longText('account_id')->nullable();
            $table->longText('description')->nullable();
            $table->longText('attachment')->nullable();
            $table->double('amount',20,2)->nullable();
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
        Schema::dropIfExists('general_bill_details');
    }
}
