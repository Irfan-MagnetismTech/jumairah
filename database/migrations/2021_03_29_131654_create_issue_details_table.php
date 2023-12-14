<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('issue_id');
            $table->string('product_remarks')->nullable();
            $table->integer('raw_material_id')->nullable();
            $table->decimal('quantity', 20, 2)->nullable();
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
        Schema::dropIfExists('issue_details');
    }
}
