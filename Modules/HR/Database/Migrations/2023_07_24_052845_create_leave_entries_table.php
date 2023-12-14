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
        Schema::create('leave_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('leave_type_id');
            $table->date('apply_date');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('total_day');
            $table->integer('is_approved')->default(0);
            $table->integer('is_reject')->default(0);
            $table->integer('approved_com_id')->nullable();
            $table->text('reason');
            $table->text('remarks')->nullable();
            $table->year('leave_year');

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
        Schema::dropIfExists('leave_entries');
    }
};
