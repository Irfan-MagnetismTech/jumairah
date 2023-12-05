<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentShiftingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_shiftings', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_id');
            $table->date('date')->nullable();
            $table->integer('old_project_id');
            $table->integer('old_apartment_id');
            $table->decimal('old_apartment_size')->nullable();
            $table->decimal('old_apartment_rate')->nullable();
            $table->integer('old_utility_no')->nullable();
            $table->decimal('old_utility_price')->nullable();
            $table->integer('old_reserve_no')->nullable();
            $table->decimal('old_reserve_rate')->nullable();
            $table->integer('old_parking_no')->nullable();
            $table->decimal('old_parking_price')->nullable();
            $table->decimal('old_total_value', 20,2)->nullable();

            $table->integer('new_project_id');
            $table->integer('new_apartment_id');
            $table->decimal('new_apartment_size')->nullable();
            $table->decimal('new_apartment_rate')->nullable();
            $table->integer('new_utility_no')->nullable();
            $table->decimal('new_utility_price')->nullable();
            $table->integer('new_reserve_no')->nullable();
            $table->decimal('new_reserve_rate')->nullable();
            $table->integer('new_parking_no')->nullable();
            $table->decimal('new_parking_price')->nullable();
            $table->decimal('new_total_value',20,2)->nullable();

            $table->date('hand_over_date')->nullable();
            $table->decimal('tf_percentage');
            $table->decimal('transfer_fee', 20,2);
            $table->decimal('discount', 20,2)->nullable();

            $table->string('attachment')->nullable();
            $table->integer('stage')->default(1);
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
        Schema::dropIfExists('apartment_shiftings');
    }
}
