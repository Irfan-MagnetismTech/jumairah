<?php

namespace Database\Seeders;

use App\Boq\Configurations\BoqFloor;
use App\Boq\Configurations\BoqFloorType;
use Illuminate\Database\Seeder;

class BoqFloorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pile            = BoqFloorType::where('name', 'pile')->first()?->id;
        $side_protection = BoqFloorType::where('name', 'side protection')->first()?->id;
        $foundation      = BoqFloorType::where('name', 'foundation')->first()?->id;
        $basement        = BoqFloorType::where('name', 'basement')->first()?->id;
        $mezzanine       = BoqFloorType::where('name', 'mezzanine')->first()?->id;
        $ground          = BoqFloorType::where('name', 'ground')->first()?->id;
        $floor           = BoqFloorType::where('name', 'floor')->first()?->id;
        $roof            = BoqFloorType::where('name', 'roof')->first()?->id;

        // pile -> type_id = 1
        BoqFloor::create(['name' => 'Shore pile', 'type_id' => $pile]);
        BoqFloor::create(['name' => 'Dead pile', 'type_id' => $pile]);
        BoqFloor::create(['name' => 'Sheet pile', 'type_id' => $pile]);
        BoqFloor::create(['name' => 'Service pile', 'type_id' => $pile]);
        BoqFloor::create(['name' => 'Sand pile', 'type_id' => $pile]);

        // Pile -> type_id = 2
        BoqFloor::create(['name' => 'Side protection', 'type_id' => $side_protection]);

        // Foundation -> type_id = 3
        BoqFloor::create(['name' => 'Foundation with mat', 'type_id' => $foundation]);
        BoqFloor::create(['name' => 'Foundation with ground level', 'type_id' => $foundation]);

        // Basement -> type_id = 4
        for ($i = 1; $i <= 100; $i++)
        {
            BoqFloor::create(['name' => 'Basement ' . $i, 'type_id' => $basement]);
        }

        // Mezzanine -> type_id = 5
        BoqFloor::create(['name' => 'Mezzanine', 'type_id' => $mezzanine]);

        // Ground -> type_id = 6
        BoqFloor::create(['name' => 'Ground Floor', 'type_id' => $ground]);

        // Floor -> type_id = 7
        for ($i = 1; $i <= 200; $i++)
        {
            BoqFloor::create(['name' => 'Floor ' . $i, 'type_id' => $floor]);
        }

        // Roof -> type_id = 8
        BoqFloor::create(['name' => 'Roof Top', 'type_id' => $roof]);
    }
}
