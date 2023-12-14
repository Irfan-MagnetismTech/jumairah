<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_registers', function (Blueprint $table) {
            $table->id();
            $table->integer('serial_no');
            $table->string('bill_no')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->integer('status')->default(0)->comment('0=>pending,1=>accepted');
            $table->integer('deliver_status')->default(0)->comment('0=>pending,1=>delivered');
            $table->double('amount',20,2);
            $table->string('accepted_date')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('approval_status')->nullable();
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
        Schema::dropIfExists('bill_registers');
    }
}
