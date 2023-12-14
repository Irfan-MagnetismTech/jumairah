<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasiPerticularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasi_perticulars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->on('units')->references('id')->onDelete('cascade');
            $table->string('type');
            $table->string('dependency_type')->comment('0 => none,1 => total_revenue,2 => total_buildup_area,3 => gf_area + buildupfar_area+ bonus_saleable_area,4=>basement_area');
            $table->integer('statuts');
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
        Schema::dropIfExists('bd_feasi_perticulars');
    }
}
