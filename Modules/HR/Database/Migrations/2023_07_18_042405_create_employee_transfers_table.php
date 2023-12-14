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
        Schema::create('employee_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('transfer_type');
            $table->date('transfer_date');
            $table->date('join_date');
            $table->unsignedBigInteger('old_designation_id');
            $table->unsignedBigInteger('new_designation_id')->nullable();
            $table->unsignedBigInteger('old_department_id');
            $table->unsignedBigInteger('new_department_id')->nullable();
            $table->unsignedBigInteger('old_section_id');
            $table->unsignedBigInteger('new_section_id')->nullable();
            $table->unsignedBigInteger('old_emp_type_id');
            $table->unsignedBigInteger('new_emp_type_id')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('employee_transfers');
    }
};
