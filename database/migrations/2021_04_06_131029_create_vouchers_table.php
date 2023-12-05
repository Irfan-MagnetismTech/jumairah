<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('voucher_type')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
//
//  "ledger_head" => "2"
//  "supplier" => "12"
//  "payment_type" => "Cash"
//  "bank" => "1"
//  "cheque_no" => "85555"
//  "amount" => "222"
//  "cr_dr_status" => "Cash Debit"
//  "narration" => "asd asdf asdf asdf as fasd f"
//
//    'date',
//    'Payment_type',
//    'Category_id',
//    'Chq_no',
//    'Bank_id',
//    'cash_acount_id',
//    'payment_to',
//    'received_id',
//    'amount',
//    'Description',
//    'Remarks',

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
