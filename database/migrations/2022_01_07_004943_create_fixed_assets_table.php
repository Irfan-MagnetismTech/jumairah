<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_assets', function (Blueprint $table) {
            $table->id();
            $table->date('received_date')->nullable();
            $table->integer('material_id')->nullable();
            $table->string('tag');
            $table->integer('mrr_no')->nullable();
            $table->string('bill_no')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('cost_center_id')->nullable();
            $table->integer('cr_account_id')->nullable();
            $table->string('name')->nullable();
            $table->string('department_id')->nullable();
            $table->string('life_time')->nullable();
            $table->string('location')->nullable();
            $table->date('use_date')->nullable();
            $table->string('asset_type')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial')->nullable();
            $table->decimal('percentage',20,2)->nullable();
            $table->decimal('price',20,2)->nullable();
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
        Schema::dropIfExists('fixed_assets');
    }
}
