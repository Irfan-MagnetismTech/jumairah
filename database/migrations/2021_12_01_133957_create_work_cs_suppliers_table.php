<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkCsSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_cs_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_cs_id')->constrained('work_cs', 'id')->cascadeOnDelete();
            $table->integer('supplier_id')->nullable();
            $table->boolean('is_checked')->default(false);
            $table->string('vat')->nullable();
            $table->string('advanced')->nullable();
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
        Schema::dropIfExists('work_cs_suppliers');
    }
}
