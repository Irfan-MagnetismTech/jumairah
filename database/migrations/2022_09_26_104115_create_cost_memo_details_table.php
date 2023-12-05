<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostMemoDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_memo_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cost_memo_id');
            $table->foreign('cost_memo_id')->on('cost_memos')->references('id')->onDelete('cascade');
            $table->string('particulers');
            $table->integer('amount');
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
        Schema::dropIfExists('cost_memo_details');
    }
}
