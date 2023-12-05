<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgerEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->bigInteger('account_id');
            $table->string('ref_bill')->nullable();
            $table->decimal('dr_amount', 18, 2)->nullable();
            $table->decimal('cr_amount', 18, 2)->nullable();
            $table->bigInteger('person_id')->nullable();
            $table->bigInteger('cost_center_id')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('transaction_id')->on('transactions')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledger_entries');
    }
}
