<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleCancellationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_cancellations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sell_id");
            $table->date("applied_date");
            $table->string("cancelled_by"); //developer or client
            $table->decimal("paid_amount", 18, 2);
            $table->decimal("service_charge", 18, 2);
            $table->decimal("deducted_amount", 18, 2);
            $table->decimal("refund_amount", 18, 2);
            $table->string("attachment")->nullable();
            $table->text("remarks")->nullable();
            $table->string("status")->nullable();
            $table->unsignedBigInteger("entry_by");

            $table->date("approved_date")->nullable();
            $table->decimal("approved_service_charge", 18, 2)->nullable();
            $table->decimal("approved_deducted_amount", 18, 2)->nullable();
            $table->decimal("discount_amount", 18, 2)->nullable();
            $table->unsignedBigInteger("approved_by")->nullable();

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
        Schema::dropIfExists('sale_cancellations');
    }
}
