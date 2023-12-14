<?php

namespace Database\Seeders;

use App\Procurement\Materialbudgetdetail;
use Illuminate\Database\Seeder;

class MaterialbudgetdetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materialbudgetdetails = [
            ['material_budget_id'=>1,'material_id'=>1,'category_id'=>1,'material_type_id'=>1,'material_size_id'=>1,'quantity'=>5,'amount'=>2500],
            ['material_budget_id'=>1,'material_id'=>2,'category_id'=>1,'material_type_id'=>2,'material_size_id'=>2,'quantity'=>2,'amount'=>7500],
            ['material_budget_id'=>1,'material_id'=>3,'category_id'=>1,'material_type_id'=>1,'material_size_id'=>2,'quantity'=>3,'amount'=>500],
            ['material_budget_id'=>1,'material_id'=>4,'category_id'=>2,'material_type_id'=>2,'material_size_id'=>1,'quantity'=>6,'amount'=>2000],
            ['material_budget_id'=>1,'material_id'=>5,'category_id'=>2,'material_type_id'=>1,'material_size_id'=>2,'quantity'=>7,'amount'=>4000],
            ['material_budget_id'=>2,'material_id'=>6,'category_id'=>1,'material_type_id'=>1,'material_size_id'=>1,'quantity'=>1,'amount'=>2000],
            ['material_budget_id'=>2,'material_id'=>7,'category_id'=>1,'material_type_id'=>2,'material_size_id'=>2,'quantity'=>5,'amount'=>5000],
            ['material_budget_id'=>2,'material_id'=>8,'category_id'=>2,'material_type_id'=>2,'material_size_id'=>1,'quantity'=>4,'amount'=>8000],
            ['material_budget_id'=>2,'material_id'=>9,'category_id'=>2,'material_type_id'=>1,'material_size_id'=>2,'quantity'=>10,'amount'=>9000],
            ['material_budget_id'=>2,'material_id'=>10,'category_id'=>2,'material_type_id'=>2,'material_size_id'=>1,'quantity'=>400,'amount'=>10000],

        ];
        foreach($materialbudgetdetails as $materialbudgetdetail){
            Materialbudgetdetail::create($materialbudgetdetail);
        }
    }
}
