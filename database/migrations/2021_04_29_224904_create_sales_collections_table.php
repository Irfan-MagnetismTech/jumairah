<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_collections', function (Blueprint $table) {
            $table->id();
            $table->integer('sell_id');
            $table->date('received_date');
            $table->decimal('received_amount',$precision = 18, $scale = 2);
            $table->string('payment_mode');
            $table->string('source_name')->nullable();
            $table->string('transaction_no')->nullable();
            $table->date('dated')->nullable();
            $table->text('remarks')->nullable();
            $table->text('attachment')->nullable();
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
        Schema::dropIfExists('sales_collections');
    }
}
