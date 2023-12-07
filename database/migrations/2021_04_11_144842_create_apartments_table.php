<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('project_id');
            $table->string('name');
            $table->string('apartment_type');
            $table->string('type_composite_key');

            $table->integer('floor');
            $table->string('face');
            $table->string('owner');
            $table->decimal('apartment_size', $precision = 18, $scale = 2);
            $table->decimal('apartment_rate', $precision = 18, $scale = 2)->nullable();
            $table->decimal('apartment_value', $precision = 18, $scale = 2)->nullable();
            $table->decimal('parking_no', $precision = 18, $scale = 2)->nullable();
            $table->decimal('parking_rate', $precision = 18, $scale = 2)->nullable();
            $table->decimal('parking_price', $precision = 16, $scale = 2)->nullable();
            $table->decimal('utility_no', $precision = 18, $scale = 2)->nullable();
            $table->decimal('utility_rate', $precision = 18, $scale = 2)->nullable();
            $table->decimal('utility_fees', $precision = 18, $scale = 2)->nullable();
            $table->decimal('reserve_no', $precision = 18, $scale = 2)->nullable();
            $table->decimal('reserve_rate', $precision = 18, $scale = 2)->nullable();
            $table->decimal('reserve_fund', $precision = 18, $scale = 2)->nullable();
            $table->decimal('others', $precision = 18, $scale = 2)->nullable();
            $table->decimal('total_value', $precision = 18, $scale = 2)->nullable();

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
        Schema::dropIfExists('apartments');
    }
}
