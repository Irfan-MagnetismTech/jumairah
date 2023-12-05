<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentHandoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_handovers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_id'); 
            $table->date('handover_date'); 
            $table->text('remarks')->nullable();
            $table->string('status')->nullable()->default("Pending");
            $table->unsignedBigInteger('authority_id')->nullable(); 
            $table->unsignedBigInteger('audit_id')->nullable(); 
            $table->unsignedBigInteger('accountant_id')->nullable();             
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
        Schema::dropIfExists('apartment_handovers');
    }
}
