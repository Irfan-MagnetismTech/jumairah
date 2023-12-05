<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructionBillLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('construction_bill_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('construction_bill_id')->references('id')->on('construction_bills')->onDelete('cascade');
            $table->unsignedInteger('billing_title_id');
            $table->double('amount', 20, 2);
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
        Schema::dropIfExists('construction_bill_lines');
    }
}
