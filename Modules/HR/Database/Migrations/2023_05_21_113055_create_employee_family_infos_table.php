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
        Schema::create('employee_family_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('father_name')->nullable();
            $table->string('father_name_bangla')->nullable();
            $table->string('father_nid')->nullable();
            $table->string('father_mobile')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_name_bangla')->nullable();
            $table->string('mother_nid')->nullable();
            $table->string('mother_mobile')->nullable();
            $table->tinyInteger('is_married')->default(0);
            $table->string('spouse_name')->nullable();
            $table->string('spouse_name_bangla')->nullable();
            $table->string('spouse_nid')->nullable();
            $table->string('spouse_mobile')->nullable();
            $table->integer('child_number')->nullable();
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
        Schema::dropIfExists('employee_family_infos');
    }
};
