<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapCsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrap_cs', function (Blueprint $table) {
            $table->id();
            $table->date('effective_date');
            $table->date('expiry_date');
            $table->unsignedBigInteger('applied_by');
            $table->unsignedBigInteger('cost_center_id');
            $table->text('remarks')->nullable();
            $table->string('reference_no', 255);
            $table->string('status', 255)->nullable();
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
        Schema::dropIfExists('scrap_cs');
    }
}
