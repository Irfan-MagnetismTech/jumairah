<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->id();
//            $table->unsignedBigInteger('client_id');
            $table->integer('apartment_id');
            $table->integer('sell_by');

            $table->date('booking_money_date');
            $table->date('downpayment_date')->nullable();
            $table->date('sell_date')->nullable();

            $table->decimal('apartment_size', 18, 2);
            $table->decimal('apartment_rate', 18, 2);
            $table->decimal('apartment_value', 18, 2);
            $table->decimal('parking_no', 18, 2)->nullable();
            $table->decimal('parking_price', 18, 2)->nullable();
            $table->decimal('utility_no', 18, 2);
            $table->decimal('utility_price', 18, 2);
            $table->decimal('utility_fees', 18, 2);
            $table->decimal('reserve_no', 18, 2);
            $table->decimal('reserve_rate', 18, 2);
            $table->decimal('reserve_fund', 18, 2);
            $table->decimal('others', 18, 2);
            $table->decimal('total_value', 18, 2);
            $table->decimal('booking_money', 18, 2);
            $table->decimal('downpayment', 18, 2);
            $table->decimal('installment', 18, 2);

            $table->date('hand_over_date', 18, 2)->nullable();
            $table->integer('ho_grace_period', 18, 2)->nullable();
            $table->decimal('rental_compensation', 18, 2)->nullable();
            $table->decimal('cancellation_fee', 18, 2)->nullable();
            $table->decimal('transfer_fee', 18, 2)->nullable();

//            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();


//            $table->float('apartment_size', 10, 2);
//            $table->float('apartment_rate', 10, 2);
//            $table->float('apartment_value', 10, 2);
//            $table->float('parking_no', 10, 2)->nullable();
//            $table->float('parking_price', 10, 2)->nullable();
//            $table->float('utility_no', 10, 2);
//            $table->float('utility_price', 10, 2);
//            $table->float('utility_fees', 10, 2);
//            $table->float('reserve_no', 10, 2);
//            $table->float('reserve_rate', 10, 2);
//            $table->float('reserve_fund', 10, 2);
//            $table->float('others', 10, 2);
//            $table->float('total_value', 10, 2);
//            $table->float('booking_money', 10, 2);
//            $table->date('booking_money_date');
//            $table->float('downpayment', 10, 2);
//            $table->date('downpayment_date');
//            $table->float('installment', 10, 2);



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sells');
    }
}
