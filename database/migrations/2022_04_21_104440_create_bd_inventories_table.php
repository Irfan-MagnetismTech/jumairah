<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_inventories', function (Blueprint $table) {
            $table->id();
            $table->date('applied_date');
            $table->year('year');
            $table->decimal('total_signing_money', 20,2);
            $table->decimal('total_inventory_value', 20, 2);
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
        Schema::dropIfExists('bd_inventories');
    }
}
