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
        Schema::create('bonus_settings', function (Blueprint $table) {
            $table->id();
            $table->string('bonus_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('based_on');
            $table->string('amount_type');
            $table->integer('amount');
            $table->integer('applicable_after')->default(0)->comment('unit: month');
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
        Schema::dropIfExists('bonus_settings');
    }
};
