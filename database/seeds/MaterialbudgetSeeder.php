<?php

namespace Database\Seeders;

use App\Procurement\Materialbudget;
use Illuminate\Database\Seeder;

class MaterialbudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materialbudgets = [
            ['project_id'=>1,'entry_by'=>1,'entry_date'=>'2019-04-12'],
            ['project_id'=>2,'entry_by'=>1,'entry_date'=>'2020-06-23'],
            ['project_id'=>3,'entry_by'=>1,'entry_date'=>'2021-03-15'],
            ['project_id'=>4,'entry_by'=>1,'entry_date'=>'2021-07-01'],
            ['project_id'=>5,'entry_by'=>1,'entry_date'=>'2019-02-10'],
        ];
        foreach($materialbudgets as $materialbudget){
            Materialbudget::create($materialbudget);
        }
    }
}
