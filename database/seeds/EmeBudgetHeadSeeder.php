<?php

namespace Database\Seeders;

use App\Boq\Departments\Eme\EmeBudgetHead;
use Illuminate\Database\Seeder;

class EmeBudgetHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $budgetHeadData = [
            ['name'=>'Internal Electrification Work (Materials and Labour)','user_id'=>1],
            ['name'=>'Passenger Lift','user_id'=>1],
            ['name'=>'Car Lift','user_id'=>1],
            ['name'=>'Generator','user_id'=>1],
            ['name'=>'Sub-Station','user_id'=>1],
            ['name'=>'BBT (Total system)','user_id'=>1],
            ['name'=>'CCTV System','user_id'=>1],
            ['name'=>'PABX/Video Intercom System','user_id'=>1],
            ['name'=>'Fire Fighting System','user_id'=>1],
            ['name'=>'Automation System','user_id'=>1],
            ['name'=>'Swimming Pool Equipment','user_id'=>1],
            ['name'=>'Gym Equipment','user_id'=>1],
            ['name'=>'Steam Bath System','user_id'=>1],
            ['name'=>'Air Condition','user_id'=>1]
        ];
        foreach($budgetHeadData as $data){
            EmeBudgetHead::create($data);
        }
    }
}
