<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierbillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplierbills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_center_id');
            $table->unsignedBigInteger('supplier_id');
            $table->text('purpose');
            $table->date('date');
            $table->bigInteger('register_serial_no');
            $table->string('bill_no');
            $table->foreignId('applied_by');
            $table->string('status');
            $table->bigInteger('carrying_charge')->nullable();
            $table->bigInteger('labour_charge')->nullable();
            $table->bigInteger('discount')->nullable();
            $table->bigInteger('final_total');
            $table->date('request_date')->nullable();
            $table->integer('is_requested')->default(0)->comment('0=>no,1=>yes');
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
        Schema::dropIfExists('supplierbills');
    }
}
