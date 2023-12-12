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
        Schema::create('processed_bonuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bonus_id')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('processed_bonuses');
    }
};
