<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeUtilityBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_utility_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('apartment_id');
            $table->string('period');
            $table->string('meter_no');
            $table->decimal('previous_reading',20,5);
            $table->decimal('present_reading',20,5);
            $table->decimal('electricity_rate',20,5);
            $table->decimal('common_electric_amount',20,5);
            $table->decimal('vat_tax_percent',20,2)->default(0.00);
            $table->decimal('demand_charge_percent',20,2)->default(0.00);
            $table->decimal('pfc_charge_percent',20,2)->default(0.00);
            $table->decimal('delay_charge_percent',20,2)->default(0.00);
            $table->decimal('due_amount',20,5)->default(0);
            $table->decimal('total_electric_amount_aftervat',20,5);
            $table->decimal('total_bill',20,5);
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
        Schema::dropIfExists('boq_eme_utility_bills');
    }
}
