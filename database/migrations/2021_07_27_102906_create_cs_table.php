<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cs', function (Blueprint $table) {
            $table->id();
            $table->date('effective_date');
            $table->date('expiry_date');
            $table->unsignedBigInteger('applied_by');
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
        Schema::dropIfExists('cs');
    }
}
