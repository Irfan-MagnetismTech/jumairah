<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('category');
            $table->string('agreement')->nullable();
            $table->string('floor_plan')->nullable();
            $table->string('others')->nullable();

            $table->string('photo')->nullable();
            $table->string('nid')->nullable();
            $table->string('tin')->nullable();
            $table->string('doa')->nullable();
            $table->string('poa')->nullable();
            $table->string('khajna_receipt')->nullable();
            $table->string('khatiyan')->nullable();
            $table->string('warishion_certificate')->nullable();
            $table->string('luc')->nullable();
            $table->string('cda')->nullable();
            $table->string('nec')->nullable();
            $table->string('electricity_bill')->nullable();
            $table->string('wasa_billl')->nullable();
            $table->string('holding_tex')->nullable();
            $table->string('gas_bill')->nullable();


            $table->string('generator')->nullable();
            $table->string('features')->nullable();

            $table->date('signing_date');
            $table->date('cda_approval_date');
            $table->date('innogration_date')->nullable();
            $table->date('handover_date')->nullable();

            $table->integer('storied');
            $table->integer('res_storied_from')->nullable();
            $table->integer('res_storied_to')->nullable();
            $table->integer('com_storied_from')->nullable();
            $table->integer('com_storied_to')->nullable();
            $table->integer('commercial_storied')->nullable();
            $table->integer('basement')->nullable();
            $table->integer('types')->nullable();
            $table->integer('units');
            $table->integer('parking');
            $table->integer('lift')->nullable();

            $table->decimal('project_cost',$precision = 18, $scale = 2);
            $table->decimal('landsize',$precision = 18, $scale = 2);
            $table->decimal('buildup_area',$precision = 18, $scale = 2);
            $table->decimal('sellable_area',$precision = 18, $scale = 2);
            $table->decimal('landowner_share',$precision = 18, $scale = 2);
            $table->decimal('developer_share',$precision = 18, $scale = 2);
            $table->decimal('landowner_unit',$precision = 18, $scale = 2);
            $table->decimal('developer_unit',$precision = 18, $scale = 2);
            $table->decimal('landowner_parking',$precision = 18, $scale = 2);
            $table->decimal('developer_parking',$precision = 18, $scale = 2);
            $table->decimal('lO_sellable_area',$precision = 18, $scale = 2);
            $table->decimal('developer_sellable_area',$precision = 18, $scale = 2);
            $table->decimal('landowner_cash_benefit',$precision = 18, $scale = 2)->nullable();
            $table->decimal('rebate_charge',$precision = 10, $scale = 2)->nullable();
            $table->decimal('delay_charge',$precision = 10, $scale = 2)->nullable();
            $table->decimal('rental_compensation',$precision = 10, $scale = 2)->nullable();



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
        Schema::dropIfExists('projects');
    }
}
