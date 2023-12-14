<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningRawMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opening_raw_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cost_center_id');
            $table->date('applied_date');
            $table->integer('entry_by');
            $table->integer('status')->default(0)->comment('0 => pending, 1 => stock inn');
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
        Schema::dropIfExists('opening_raw_materials');
    }
}
