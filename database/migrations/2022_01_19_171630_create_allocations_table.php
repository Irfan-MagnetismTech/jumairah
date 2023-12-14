<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocations', function (Blueprint $table) {
            $table->id();
            $table->date('month')->nullable();
            $table->decimal('management_fee', 20,2)->nullable();
            $table->decimal('division_fee', 20,2)->nullable();
            $table->decimal('construction_depreciation', 20,2)->nullable();
            $table->decimal('architecture_fee', 20,2)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('allocations');
    }
}
