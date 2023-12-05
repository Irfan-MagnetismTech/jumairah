<?php

use Illuminate\Database\Seeder;

class LcCostHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lcCostHeads =  [

            ['name' => 'L/C Commission & Others','section_id'=>1],
            ['name' => 'Invoice Value @ 84.95/USD','section_id'=>1],
            ['name' => 'Import duty & Others','section_id'=>3],
            ['name' => 'Total Global Tax','section_id'=>2],
            ['name' => 'Amendment','section_id'=>1],
            ['name' => 'Shipping Agency Fine','section_id'=>1],
            ['name' => 'Carrying Charge @ 11000','section_id'=>1],
            ['name' => 'Miscellaneous (C&F)','section_id'=>1],
            ['name' => 'Miscellaneous (Shipping)','section_id'=>1],
            ['name' => 'Bank Commission & Others','section_id'=>3],
            ['name' => 'Invoice Value','section_id'=>1],
            ['name' => 'Duty (Approx','section_id'=>1],
            ['name' => 'Amendment Charge','section_id'=>1],
            ['name' => 'U-Pass (8,073.78','section_id'=>1],
            ['name' => 'Marine Insurance','section_id'=>1],
            ['name' => 'Global Taxes','section_id'=>1],
            ['name' => 'River dues','section_id'=>1],
            ['name' => 'DF Vat','section_id'=>1],
            ['name' => 'Testing Fee','section_id'=>1],
            ['name' => 'Carrying Charge-(VOTT to Plant) Per Trip 15.50 MT x 11000(54 Trip)','section_id'=>1],
            ['name' => 'Royal Inspection Survey'],
            ['name' => 'Product gain/loss','section_id'=>1],
            ['name' => 'Misc Exp.','section_id'=>1],
            ['name' => 'Stamp','section_id'=>1],
            ['name' => 'Custom Interest (Approx)','section_id'=>1],
            ['name' => 'C&F Commission (Approx)','section_id'=>2],
        ];
        foreach($lcCostHeads as $lcCostHead){
            \App\LcCostHead::create($lcCostHead);
        }
    }
}
