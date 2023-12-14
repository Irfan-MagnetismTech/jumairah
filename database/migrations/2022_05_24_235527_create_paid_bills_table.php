<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaidBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_bills', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id');
            $table->integer('account_id');
            $table->integer('cost_center_id');
            $table->string('ref_bill')->nullable();
            $table->decimal('amount',20, 2);
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
        Schema::dropIfExists('paid_bills');
    }
}
