<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateNestedMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nested_materials', function (Blueprint $table) {
            $table->id();
            NestedSet::columns($table);
            $table->string('name');
            $table->foreignId('unit_id')->nullable();
            $table->foreignId('account_id')->nullable();
            $table->string('material_status', 50)->nullable();
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
        Schema::dropIfExists('nested_materials');
    }
}
