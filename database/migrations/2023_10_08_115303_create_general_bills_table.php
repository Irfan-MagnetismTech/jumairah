<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_bills', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('cost_center_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('mrr_id')->nullable();
            $table->unsignedBigInteger('mpr_id')->nullable();
            $table->double('total_amount',20,2)->nullable();
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
        Schema::dropIfExists('general_bills');
    }
}
