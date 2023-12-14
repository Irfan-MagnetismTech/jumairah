<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialmovementdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materialmovementdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materialmovement_id');
            $table->unsignedBigInteger('fixed_asset_id')->nullable();
            $table->integer('movement_requision_id');
            $table->string('gate_pass');
            $table->integer('material_id');
            $table->integer('quantity');
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->foreign('materialmovement_id')->on('materialmovements')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materialmovementdetails');
    }
}
