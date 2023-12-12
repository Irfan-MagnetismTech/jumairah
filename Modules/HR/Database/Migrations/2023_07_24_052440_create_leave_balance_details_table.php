<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_balance_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_balance_id');
            $table->integer('cl');
            $table->integer('cl_enjoyed')->nullable();
            $table->integer('sl');
            $table->integer('sl_enjoyed')->nullable();
            $table->integer('el');
            $table->integer('el_enjoyed')->nullable();
            $table->integer('ml');
            $table->integer('ml_enjoyed')->nullable();
            $table->integer('other');
            $table->integer('other_enjoyed')->nullable();
            $table->integer('is_active')->default(1);

            $table->uuid('com_id')->nullable();
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
        Schema::dropIfExists('leave_balance_details');
    }
};
