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
        Schema::create('finger_print_device_infos', function (Blueprint $table) {
            $table->id();
            $table->string('device_name')->nullable();
            $table->string('device_ip')->nullable();
            $table->string('device_serial')->nullable();
            $table->string('device_location')->nullable();
            $table->string('device_port')->nullable();
            $table->string('device_type')->nullable();
            $table->string('device_model')->nullable();
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
        Schema::dropIfExists('finger_print_device_infos');
    }
};
