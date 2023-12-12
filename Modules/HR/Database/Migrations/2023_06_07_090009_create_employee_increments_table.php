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
        Schema::create('employee_increments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');

            $table->string('incement_type');
            $table->date('date');
            $table->unsignedBigInteger('old_designation_id');
            $table->unsignedBigInteger('new_designation_id')->nullable();
            $table->unsignedBigInteger('old_section_id');
            $table->unsignedBigInteger('new_section_id')->nullable();
            $table->unsignedBigInteger('old_emp_type_id');
            $table->unsignedBigInteger('new_emp_type_id')->nullable();


            $table->string('old_gs')->nullable();
            $table->string('old_bs')->nullable();
            $table->string('old_hr')->nullable();
            $table->string('old_ta')->nullable();
            $table->string('old_fa')->nullable();
            $table->string('old_ma')->nullable();

            $table->string('new_gs')->nullable();
            $table->string('new_bs')->nullable();
            $table->string('new_hr')->nullable();
            $table->string('new_ta')->nullable();
            $table->string('new_fa')->nullable();
            $table->string('new_ma')->nullable();

            $table->string('increment_amount')->nullable();
            $table->string('increment_percentage')->nullable();
            $table->text('remarks');
            $table->integer('increment_status')->default(1);
            $table->uuid('com_id')->nullable();
            $table->timestamps();
            // $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_increments');
    }
};
