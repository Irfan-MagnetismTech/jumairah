<?php

use Illuminate\Database\Seeder;

class MaterialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materialcategories = [
            ['name' => 'CONSTRUCTION MATERIALS', 'type'=>'Non-reusable'],
            ['name' => 'MARBLE/GRANITE/TILES/PAVERS', 'type'=>'Non-reusable'],
            ['name' => 'WOODEN DOOR MATERIALS', 'type'=>'Non-reusable'],
            ['name' => 'PAINTING MATERIALS', 'type'=>'Non-reusable'],
            ['name' => 'MATERIALS WITH LABOR', 'type'=>'Non-reusable'],
            ['name' => 'MS WORK', 'type'=>'Non-reusable'],
            ['name' => 'FALSE CEILING WORK', 'type'=>'Non-reusable'],
            ['name' => 'GLAZING WORK', 'type'=>'Non-reusable'],
            ['name' => 'CONSTRUCTION EQUIPMENT', 'type'=>'Re-usable'],
            ['name' => 'STEEL SHUTTERING MATERIALS', 'type'=>'Re-usable'],
            ['name' => 'SAFETY STAGING & CANOPY MATERIALS', 'type'=>'Re-usable'],
            ['name' => 'MISCELLANEOUS CONSTRUCTION MATERIALS', 'type'=>'Non-reusable'],
        ];
        foreach($materialcategories as $category){
         \App\Procurement\Materialcategory::create($category);
        }
    }
}
