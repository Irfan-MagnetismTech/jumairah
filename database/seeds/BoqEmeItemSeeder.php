<?php

namespace Database\Seeders;

use App\Boq\Departments\Eme\BoqEmeItem;
use Illuminate\Database\Seeder;

class BoqEmeItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoqEmeItem::create(
            [
                'name'         => 'Internal Electrification',
                'remarks'      => 'Internal Electrification',
                'is_mat'       => true,
                'is_lab'       => false,
                'is_composite' => false,
                'children'     => [
                    [
                        'name'         => 'Electrical PVC Materials',
                        'remarks'      => 'Electrical PVC Materials',
                        'is_mat'       => true,
                        'is_lab'       => false,
                        'is_composite' => false,
                    ],
                    [
                        'name'         => 'Electrical Cable',
                        'remarks'      => 'Electrical Cable',
                        'is_mat'       => true,
                        'is_lab'       => false,
                        'is_composite' => false,
                    ],
                    [
                        'name'         => 'Electrical Switch & Socket',
                        'remarks'      => 'Electrical Switch & Socket',
                        'is_mat'       => true,
                        'is_lab'       => false,
                        'is_composite' => false,
                    ],
                    [
                        'name'         => 'Electrical Circuit Breaker',
                        'remarks'      => 'Electrical Circuit Breaker',
                        'is_mat'       => true,
                        'is_lab'       => false,
                        'is_composite' => false,
                    ],
                    [
                        'name'         => 'Electrical Light / Shade',
                        'remarks'      => 'Electrical Light / Shade',
                        'is_mat'       => true,
                        'is_lab'       => false,
                        'is_composite' => false,
                    ],
                    [
                        'name'         => 'Electrical Pump & Control Box',
                        'remarks'      => 'Electrical Pump & Control Box',
                        'is_mat'       => true,
                        'is_lab'       => false,
                        'is_composite' => false,
                    ],
                    [
                        'name'         => 'EME Miscellaneous Items',
                        'remarks'      => 'EME Miscellaneous Items',
                        'is_mat'       => true,
                        'is_lab'       => false,
                        'is_composite' => false,
                    ],
                    [
                        'name'         => 'Electrical Temporary Items',
                        'remarks'      => 'Electrical Temporary Items',
                        'is_mat'       => true,
                        'is_lab'       => false,
                        'is_composite' => false,
                    ],
                    [
                        'name'         => 'EME Machineries & Construction Items',
                        'remarks'      => 'EME Machineries & Construction Items',
                        'is_mat'       => true,
                        'is_lab'       => false,
                        'is_composite' => false,
                    ],
                ],
            ]
        );

        BoqEmeItem::create([
            'name'         => 'Electrical Sub-Station',
            'remarks'      => 'Electrical Sub-Station',
            'is_mat'       => false,
            'is_lab'       => false,
            'is_composite' => true,
            'children'     => [
                [
                    'name'         => 'Sub-Station Equipment',
                    'remarks'      => 'Sub-Station Equipment',
                    'is_mat'       => false,
                    'is_lab'       => false,
                    'is_composite' => true,
                ],
                [
                    'name'         => 'EME Panel & Voltage ATS Panel',
                    'remarks'      => 'EME Panel & Voltage ATS Panel',
                    'is_mat'       => false,
                    'is_lab'       => false,
                    'is_composite' => true,
                ],
                [
                    'name'         => 'Earthing Work',
                    'remarks'      => 'Earthing Work',
                    'is_mat'       => false,
                    'is_lab'       => false,
                    'is_composite' => true,
                ],
                [
                    'name'         => 'Solar System',
                    'remarks'      => 'Solar System',
                    'is_mat'       => false,
                    'is_lab'       => false,
                    'is_composite' => true,
                ],
            ],
        ]);

        BoqEmeItem::create([
            'name'         => 'Electrical Lift & Escalator',
            'remarks'      => 'Electrical Lift & Escalator',
            'is_mat'       => false,
            'is_lab'       => false,
            'is_composite' => true,
        ]);

        BoqEmeItem::create([
            'name'         => 'Diesel Generator',
            'remarks'      => 'Diesel Generator',
            'is_mat'       => false,
            'is_lab'       => false,
            'is_composite' => true,
        ]);

        BoqEmeItem::create([
            'name'         => 'Busbar Trunking System (BB)',
            'remarks'      => 'Busbar Trunking System (BB)',
            'is_mat'       => false,
            'is_lab'       => false,
            'is_composite' => true,
        ]);

        BoqEmeItem::create([
            'name'         => 'Ventilation System',
            'remarks'      => 'Ventilation System',
            'is_mat'       => false,
            'is_lab'       => false,
            'is_composite' => true,
        ]);

        BoqEmeItem::create([
            'name'         => 'Electric PabX System',
            'remarks'      => 'Electric PabX System',
            'is_mat'       => false,
            'is_lab'       => false,
            'is_composite' => true,
        ]);

        BoqEmeItem::create([
            'name'         => 'Electric PabX System',
            'remarks'      => 'Electric PabX System',
            'is_mat'       => false,
            'is_lab'       => false,
            'is_composite' => true,
        ]);

        BoqEmeItem::create([
            'name'         => 'HVAC System',
            'remarks'      => 'HVAC System',
            'is_mat'       => false,
            'is_lab'       => false,
            'is_composite' => true,
        ]);

        BoqEmeItem::create([
            'name'         => 'Fire Fighting System',
            'remarks'      => 'Fire Fighting System',
            'is_mat'       => false,
            'is_lab'       => false,
            'is_composite' => true,
        ]);

        BoqEmeItem::create([
            'name'         => 'Electrical AC & VRF',
            'remarks'      => 'Fire Fighting System',
            'is_mat'       => false,
            'is_lab'       => false,
            'is_composite' => true,
        ]);

        BoqEmeItem::create([
            'name'         => 'CC.TV & Security System',
            'remarks'      => 'CC.TV & Security System',
            'is_mat'       => false,
            'is_lab'       => false,
            'is_composite' => true,
        ]);
    }
}
