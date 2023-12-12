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
        Schema::create('employee_nominee_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('nominee_name')->nullable();
            $table->date('nominee_dob')->nullable();
            $table->string('nominee_proffession')->nullable();
            $table->string('nominee_mobile')->nullable();
            $table->string('nominee_nid')->nullable();
            $table->string('nominee_relation')->nullable();
            $table->string('nominee_percentage')->nullable();
            $table->text('nominee_address')->nullable();
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
        Schema::dropIfExists('employee_nominee_infos');
    }
};
