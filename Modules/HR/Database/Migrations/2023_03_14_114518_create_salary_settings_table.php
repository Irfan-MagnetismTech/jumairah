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
        Schema::create('salary_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_type_id');
            $table->string('basic')->nullable();
            $table->string('house_rent')->nullable();
            // $table->string('tansport_allowance')->nullable();
            $table->string('medical_allowance')->nullable();
            $table->string('conveyance_allowance')->nullable();
            $table->string('food_allowance')->nullable();
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
        Schema::dropIfExists('salary_settings');
    }
};
