<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapCsSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrap_cs_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scrap_cs_id')->constrained('scrap_cs', 'id')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers', 'id')->cascadeOnDelete();
            $table->string('vat_tax', 255);
            $table->decimal('security_money',20,4);
            $table->string('payment_type',255);
            $table->string('lead_time',255);
            $table->boolean('is_checked')->default(false);
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
        Schema::dropIfExists('scrap_cs_suppliers');
    }
}
