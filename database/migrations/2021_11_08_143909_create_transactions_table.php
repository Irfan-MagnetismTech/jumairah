<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_type');
            $table->string('bill_no')->nullable();
            $table->string('mr_no')->nullable();
            $table->date('transaction_date');
            $table->text('narration')->nullable();
            $table->integer('document_id')->nullable();
            $table->integer('transactionable_id')->nullable();
            $table->string('transactionable_type')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('cheque_type')->nullable();
            $table->date('cheque_date')->nullable();
            $table->integer('challan_no')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
