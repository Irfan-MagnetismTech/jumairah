<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNameTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('name_transfers', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_id');
            $table->decimal('tf_percentage');
            $table->decimal('transfer_fee', 20,2);
            $table->decimal('discount', 20,2)->nullable();
            $table->decimal('net_pay', 20,2)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('attachment')->nullable();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('name_transfers');
    }
}
