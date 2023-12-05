<?php

namespace Database\Seeders;

use App\Accounts\SalaryHead;
use App\Boq\Departments\Sanitary\SanitaryLocationType;
use Illuminate\Database\Seeder;

class SanitaryLocationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
                    ['name'   => 'Master Bath',     'type' => 1],
                    ['name'   => 'Child Bath',      'type' => 1],
                    ['name'   => 'Common Bath',     'type' => 1],
                    ['name'   => 'S. Toilet Bath',  'type' => 1],
                    ['name'   => 'Kitchen',         'type' => 1],
                    ['name'   => 'Toilet',          'type' => 0],
                    ['name'   => 'Wash Basin',      'type' => 0],
                    ['name'   => 'Urinal',          'type' => 0],
                    ['name'   => 'Pantry',          'type' => 0],
                    ['name'   => 'Common Toilet',   'type' => 0],
            ];

//        dd($types);
        SanitaryLocationType::truncate();
        foreach($types as $type){
            SanitaryLocationType::create($type);
        }
    }
}
