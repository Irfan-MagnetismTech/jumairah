<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanitaryAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanitary_allocations', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->string('floor_Type')->nullable();
            $table->integer('floor_no')->nullable();
            $table->integer('apartment_type')->nullable();
            $table->string('location_type')->nullable();
            $table->integer('owner_quantity')->nullable();
            $table->integer('fc_quantity')->nullable();
            $table->integer('type')->nullable();
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
        Schema::dropIfExists('sanitary_allocations');
    }
}
