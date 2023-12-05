<?php

use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warehouses = [
            ['name'=>'Warehouse-CTG-1','location'=>'Agrabad, Chittagong','contact_person_id'=>1],
        ];
        foreach($warehouses as $warehouse){
            \App\Warehouse::create($warehouse);
        }
    }
}
