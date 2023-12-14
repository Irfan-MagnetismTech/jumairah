<?php

namespace Database\Seeders;

use App\Boq\Configurations\BoqFloorType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BoqFloorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoqFloorType::create(['name' => Str::lower('Pile'), 'has_buildup_area' => 0, 'serial_no' => 1]);
        BoqFloorType::create(['name' => Str::lower('Side Protection'), 'has_buildup_area' => 0, 'serial_no' => 2]);
        BoqFloorType::create(['name' => Str::lower('Boundary Wall'), 'has_buildup_area' => 0, 'serial_no' => 3]);
        BoqFloorType::create(['name' => Str::lower('Foundation'), 'has_buildup_area' => 0, 'serial_no' => 4]);
        BoqFloorType::create(['name' => Str::lower('Basement'), 'has_buildup_area' => 1, 'serial_no' => 5]);
        BoqFloorType::create(['name' => Str::lower('Mezzanine'), 'has_buildup_area' => 1, 'serial_no' => 6]);
        BoqFloorType::create(['name' => Str::lower('Ground'), 'has_buildup_area' => 1, 'serial_no' => 7]);
        BoqFloorType::create(['name' => Str::lower('Floor'), 'has_buildup_area' => 1, 'serial_no' => 8]);
        BoqFloorType::create(['name' => Str::lower('Roof'), 'has_buildup_area' => 1, 'serial_no' => 9]);
    }
}
