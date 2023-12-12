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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->string('shift_in')->nullable();
            $table->string('shift_out')->nullable();
            $table->string('shift_late')->nullable();
            $table->string('lunch_time')->nullable();
            $table->string('lunch_in')->nullable();
            $table->string('lunch_out')->nullable();
            $table->string('regular_hour')->nullable();
            $table->string('tiffin_time')->nullable();
            $table->string('tiffin_in')->nullable();
            $table->string('tiffin_out')->nullable();
            $table->string('tiffin_time_2')->nullable();
            $table->string('tiffin_time_2_in')->nullable();
            $table->string('tiffin_time_2_out')->nullable();
            $table->string('status')->default('active');
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
        Schema::dropIfExists('shifts');
    }
};
