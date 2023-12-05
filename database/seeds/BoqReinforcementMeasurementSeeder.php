<?php

namespace Database\Seeders;

use App\Boq\Configurations\BoqReinforcementMeasurement;
use App\Procurement\Unit;
use Illuminate\Database\Seeder;

class BoqReinforcementMeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoqReinforcementMeasurement::create([
            'dia'    => 8,
            'weight' => 0.12,
            'unit_id' => Unit::all()->random()->id
        ]);

        BoqReinforcementMeasurement::create([
            'dia'    => 20,
            'weight' => 0.751,
            'unit_id' => Unit::all()->random()->id
        ]);
        BoqReinforcementMeasurement::create([
            'dia'    => 10,
            'weight' => 0.188,
            'unit_id' => Unit::all()->random()->id
        ]);
        BoqReinforcementMeasurement::create([
            'dia'    => 22,
            'weight' => 0.908,
            'unit_id' => Unit::all()->random()->id
        ]);
        BoqReinforcementMeasurement::create([
            'dia'    => 12,
            'weight' => 0.271,
            'unit_id' => Unit::all()->random()->id
        ]);
        BoqReinforcementMeasurement::create([
            'dia'    => 25,
            'weight' => 1.175,
            'unit_id' => Unit::all()->random()->id
        ]);
        BoqReinforcementMeasurement::create([
            'dia'    => 16,
            'weight' => 0.481,
            'unit_id' => Unit::all()->random()->id
        ]);
        BoqReinforcementMeasurement::create([
            'dia'    => 32,
            'weight' => 1.924,
            'unit_id' => Unit::all()->random()->id
        ]);
    }
}
