<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellsClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_id');
            $table->foreign('sell_id')->on('sells')->references('id')->onDelete('cascade');

            $table->integer('name_transfer_id')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->on('clients')->references('id')->onDelete('cascade');
            $table->integer('stage')->default('1');
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
        Schema::dropIfExists('sells_clients');
    }
}
