<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installment_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('installment_no');
            $table->unsignedBigInteger('sell_id');
            $table->date('installment_date');
            $table->decimal('installment_amount',18,2);
            $table->string('installment_composite');
            $table->timestamps();
            $table->foreign('sell_id')->on('sells')->references('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installment_lists');
    }
}
