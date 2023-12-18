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
        Schema::create('fix_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->string('emp_card_id')->nullable();
            $table->unsignedBigInteger('employee_type_id')->nullable();;
            $table->unsignedBigInteger('department_id')->nullable();;
            $table->unsignedBigInteger('section_id')->nullable();;
            $table->unsignedBigInteger('sub_section_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();;
            $table->unsignedBigInteger('shift_id')->nullable();;
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('floor_id')->nullable();
            $table->unsignedBigInteger('line_id')->nullable();

            $table->date('punch_date')->nullable();
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->time('late')->nullable();
            $table->time('ot_hour')->nullable();
            $table->text('other')->nullable();
            $table->text('status')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('action')->default(0);
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
        Schema::dropIfExists('fix_attendances');
    }
};
