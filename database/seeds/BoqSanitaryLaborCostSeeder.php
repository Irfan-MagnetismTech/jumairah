<?php

namespace Database\Seeders;

use App\Boq\Departments\Sanitary\SanitaryLaborCost;
use Illuminate\Database\Seeder;

class BoqSanitaryLaborCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name'=>'Double Line Toilet with COMBI COMMODE SET, CABINET/PEDSTAL BASIN including all uPVC & PPR Line work.', 'unit_id' => '12', 'rate_per_unit'=>'3500'],
            ['name'=>'Single Line Toilet with COMBI COMMODE SET, CABINET/PEDSTAL BASIN including all uPVC & PPR Line work.','unit_id' => '12',  'rate_per_unit'=>'3000'],
            ['name'=>'Single Line Toilet with COMBI COMMODE SET without BASIN including all uPVC & PPR Line work.', 'unit_id' => '12', 'rate_per_unit'=>'2500'],
            ['name'=>'Single Line Toilet with Long PAN(without BASIN) including all uPVC & PPR Line work.','unit_id' => '12',  'rate_per_unit'=>'2500'],
            ['name'=>'Double Line KITCHEN with SINK including all uPVC & PPR Line work.', 'unit_id' => '12', 'rate_per_unit'=>'2000'],
            ['name'=>'Single Line DOWN WASH including all uPVC & PPR Line work.', 'unit_id' => '12', 'rate_per_unit'=>'1500'],
            ['name'=>'Single Line for BASIN including all uPVC & PPR Line work. (Commercial Part)', 'unit_id' => '12', 'rate_per_unit'=>'1500'],
            ['name'=>'Single Line for URINAL including all uPVC & PPR Line work. (Commercial Part)', 'unit_id' => '12', 'rate_per_unit'=>'1500'],
            ['name'=>'Ground Floor uPVC Line work', 'unit_id' => '12', 'rate_per_unit'=>'30000'],
            ['name'=>'4th Floor uPVC Line work', 'unit_id' => '12', 'rate_per_unit'=>'25000'],
            ['name'=>'Roof Top PPR Line work', 'unit_id' => '12', 'rate_per_unit'=>'20000'],
            ['name'=>'MOTOR Fitting', 'unit_id' => '12', 'rate_per_unit'=>'5000'],
            ['name'=>'GAS LINE WORK', 'unit_id' => '12', 'rate_per_unit'=>'2500']
        ];

        foreach($items as $item){
            SanitaryLaborCost::create($item);
        }
    }
}
