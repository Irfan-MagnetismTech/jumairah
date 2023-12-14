<?php

namespace Database\Seeders;

use App\Boq\Configurations\BoqFloorType;
use App\Boq\Configurations\BoqWork;
use App\Procurement\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoqWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function ()
        {
            $units       = Unit::all()->pluck('id', 'name')->toArray();
            $floor_types = BoqFloorType::all()->pluck('id', 'name')->toArray();

            $getTypeId = function (...$types) use ($floor_types)
            {
                $floor_ids = [];
                foreach ($types as $type)
                {
                    $floor_ids[] = $floor_types[$type];
                }

                return $floor_ids;
            };

            // Pile Casting
            BoqWork::create([
                'name'             => 'Pile Casting',
                'material_unit'    => $units['CFT'],
                'labour_unit'      => $units['CFT'],
                'is_reinforcement' => false,
            ])->floorTypes()->attach($getTypeId('pile'));

            // Pile Shoe
            BoqWork::create([
                'name'             => 'Pile Shoe',
                'material_unit'    => $units['NO'],
                'labour_unit'      => $units['CFT'],
                'is_reinforcement' => false,
            ])->floorTypes()->attach($getTypeId('pile'));

            // Sheet Pile work
            BoqWork::create([
                'name'             => 'Sheet Pile Work',
                'material_unit'    => $units['KG'],
                'labour_unit'      => $units['CFT'],
                'is_reinforcement' => false,
            ])->floorTypes()->attach($getTypeId('pile'));

            // CC Work
            BoqWork::create([
                'name'             => 'CC Work',
                'material_unit'    => $units['CFT'],
                'labour_unit'      => $units['CFT'],
                'is_reinforcement' => false,
            ])->floorTypes()->attach($getTypeId('side protection', 'foundation', 'ground', 'boundary wall'));

            // Soiling Work
            BoqWork::create([
                'name'             => 'Soiling Work',
                'material_unit'    => $units['SFT'],
                'labour_unit'      => $units['SFT'],
                'is_reinforcement' => false,
            ])->floorTypes()->attach($getTypeId('side protection', 'foundation', 'ground', 'boundary wall'));

            // Sand Work
            BoqWork::create([
                'name'             => 'Sand Work',
                'material_unit'    => $units['CFT'],
                'labour_unit'      => $units['CFT'],
                'is_reinforcement' => false,
            ])->floorTypes()->attach($getTypeId('side protection', 'foundation', 'ground'));

            // Reinforced Cement Concrete Work
            $rcc_psi = [];
            for ($i = 2000; $i <= 5000; $i += 500)
            {
                $rcc_psi[] = [
                    'name'          => "{$i} PSI",
                    'material_unit' => $units['CFT'],
                    'labour_unit'   => $units['CFT'],
                    'labour_unit'   => $units['CFT'],
                ];
            }
            $rcc_children = [
                [
                    'name'          => 'RMC',
                    'material_unit' => $units['CFT'],
                    'labour_unit'   => $units['CFT'],
                    'labour_unit'   => $units['CFT'],
                    'children'      => $rcc_psi,
                ],
                [
                    'name'          => 'Mixture Machine',
                    'material_unit' => $units['CFT'],
                    'labour_unit'   => $units['CFT'],
                    'labour_unit'   => $units['CFT'],
                    'children'      => $rcc_psi,
                ],
                [
                    'name'          => 'Brick Chips',
                    'material_unit' => $units['NO'],
                    'labour_unit'   => $units['NO'],
                    'labour_unit'   => $units['CFT'],
                ],
            ];

            // Earth Work
            BoqWork::create([
                'name'             => 'Earth Work',
                'material_unit'    => $units['CFT'],
                'labour_unit'      => $units['CFT'],
                'is_reinforcement' => false,
            ])->floorTypes()->attach($getTypeId('foundation', 'ground', 'boundary wall'));

            // Structural Work
            $strut_work = BoqWork::create(['name' => 'Structural Work']);
            $struct_id  = $strut_work->id;

            $strut_work->floorTypes()->attach($getTypeId('basement', 'ground', 'floor', 'roof', 'boundary wall'));

            // RCC
            BoqWork::create([
                'name'          => 'RCC Work',
                'parent_id'     => $struct_id,
                'material_unit' => $units['CFT'],
                'labour_unit'   => $units['CFT'],
                'children'      => $rcc_children,
            ])->floorTypes()->attach($getTypeId('side protection', 'foundation'));

            // MS ROD
            BoqWork::create([
                'name'             => 'MS ROD',
                'parent_id'        => $struct_id,
                'material_unit'    => $units['CFT'],
                'is_reinforcement' => true,
            ])->floorTypes()->attach($getTypeId('pile', 'side protection', 'foundation'));

            // Steel I Joist
            BoqWork::create([
                'name'          => 'Steel I Joist',
                'material_unit' => $units['KG'],
                'labour_unit'   => $units['KG'],
            ])->floorTypes()->attach($getTypeId('side protection'));

            // Lintel/ False Slab/ Kitchen Top Work
            BoqWork::create([
                'name'             => 'Lintel/ False Slab/ Kitchen Top Work',
                'material_unit'    => $units['CFT'],
                'labour_unit'      => $units['CFT'],
                'is_reinforcement' => false,
            ])->floorTypes()->attach($getTypeId('basement', 'ground'));

            // Brick Work
            BoqWork::create([
                'name'     => 'Brick Work',
                'children' => [
                    [
                        'name'          => '10" Brick Work',
                        'material_unit' => $units['CFT'],
                        'labour_unit'   => $units['CFT'],
                    ],
                    [
                        'name'          => '5" Brick Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                    [
                        'name'          => 'Ceramic Brick Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                ],
            ])->floorTypes()->attach($getTypeId('side protection', 'foundation', 'ground', 'floor', 'boundary wall', 'roof'));

            //Patent Stones Work
            BoqWork::create([
                'name'             => 'Patent Stones Work',
                'material_unit'    => $units['CFT'],
                'labour_unit'      => $units['CFT'],
                'is_reinforcement' => false,
            ])->floorTypes()->attach($getTypeId('basement', 'ground', 'foundation', 'floor', 'boundary wall', 'roof'));

            // Plaster Work
            BoqWork::create([
                'name'     => 'Plaster Work',
                'children' => [
                    [
                        'name'          => 'Inside Plaster Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                    [
                        'name'          => 'Outside Plaster Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                    [
                        'name'          => 'Plaster with NCF Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                ],
            ])->floorTypes()->attach($getTypeId('basement', 'ground', 'foundation', 'floor', 'boundary wall', 'roof'));

            /* ==================================== Pavement/Granite/Marble/Tiles START ==================================== */
            $floor_tiles = [];
            $wall_tiles  = [];

            for ($i = 1; $i <= 10; $i++)
            {
                $floor_tiles[] = [
                    'name'          => "Floor Tiles {$i}",
                    'material_unit' => $units['SFT'],
                    'labour_unit'   => $units['SFT'],
                ];
                $wall_tiles[] = [
                    'name'          => "Wall Tiles {$i}",
                    'material_unit' => $units['SFT'],
                    'labour_unit'   => $units['SFT'],
                ];
            }

            //Pavement/Granite/Marble/Tiles Work
            BoqWork::create([
                'name'     => 'Pavement/Granite/Marble/Tiles Work',
                'children' => [
                    [ // Tiles Work
                        'name'          => 'Tiles Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                        'children'      => [
                            [
                                'name'          => 'Floor Tiles Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                                'children'      => $floor_tiles,
                            ],
                            [
                                'name'          => 'Wall Tiles Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                                'children'      => $wall_tiles,
                            ],
                        ],
                    ],
                    [ // Marble Work
                        'name'          => 'Marble Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                        'children'      => [
                            [
                                'name'          => 'Polished Marble Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                            ],
                            [
                                'name'          => 'Unpolished Marble Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                            ],
                        ],
                    ],
                    [ // Granite
                        'name'          => 'Granite Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                        'children'      => [
                            [
                                'name'          => '16 - 18 mm Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                            ],
                            [
                                'name'          => '10 - 12 mm Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                            ],
                        ],
                    ],
                    [ // Pavement Tiles Work
                        'name'          => 'Pavement Tiles Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                        'children'      => [
                            [
                                'name'          => '4" X 4" Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                            ],
                            [
                                'name'          => '6" X 6" Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                            ],
                            [
                                'name'          => '12" X 12" Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                            ],
                        ],

                    ],
                ],
            ])->floorTypes()->attach($getTypeId('basement', 'ground', 'floor', 'roof'));
            /* ==================================== Pavement/Granite/Marble/Tiles END ==================================== */

            // Door Frame Work
            BoqWork::create([
                'name'          => 'Door Frame Work',
                'material_unit' => $units['NO'],
                'labour_unit'   => $units['NO'],
                'children'      => [
                    [
                        'name'          => 'Main Door Frame Work',
                        'material_unit' => $units['NO'],
                        'labour_unit'   => $units['NO'],
                    ],
                    [
                        'name'          => 'Internal Door Frame Work',
                        'material_unit' => $units['NO'],
                        'labour_unit'   => $units['NO'],
                    ],
                    [
                        'name'          => 'Plastic Door Frame Work',
                        'material_unit' => $units['NO'],
                        'labour_unit'   => $units['NO'],
                    ],
                ],
            ])->floorTypes()->attach($getTypeId('basement', 'ground', 'floor', 'roof'));

            // Door Shutter
            BoqWork::create([
                'name'          => 'Door Shutter Work',
                'material_unit' => $units['SFT'],
                'labour_unit'   => $units['SFT'],
                'children'      => [
                    [
                        'name'          => 'Main Door Shutter Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                    [
                        'name'          => 'Internal Door Shutter Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                    [
                        'name'          => 'Laminated Door Shutter Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                ],
            ])->floorTypes()->attach($getTypeId('basement', 'ground', 'floor', 'roof'));

            // Materials With Labour
            BoqWork::create([
                'name'     => 'Materials With Labour',
                'children' => [
                    [ // M.S Work
                        'name'          => 'M.S Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                        'children'      => [
                            [ // Window Grill Work
                                'name'          => 'Window Grill Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                            ],
                            [ // Stair Railing Work
                                'name'          => 'Stair Railing Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                                'children'      => [
                                    [
                                        'name'          => 'With Wooden Hand Rail',
                                        'material_unit' => $units['SFT'],
                                        'labour_unit'   => $units['SFT'],
                                    ],
                                ],
                            ],
                            [ // Veranda Railing Work
                                'name'          => 'Veranda Railing Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                            ],
                            [ // M.S AC Louver Work
                                'name'          => 'M.S AC Louver Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                                'children'      => [
                                    [
                                        'name'          => 'By 1" X 1" HB',
                                        'material_unit' => $units['SFT'],
                                        'labour_unit'   => $units['SFT'],
                                    ],
                                ],
                            ],
                            [ // M.S Door Work
                                'name'          => 'M.S Door Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                            ],
                            [ // M.S Door With Louver Work
                                'name'          => 'M.S Door With Louver Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                                'children'      => [
                                    [
                                        'name'          => 'By 2" X 2" HB',
                                        'material_unit' => $units['SFT'],
                                        'labour_unit'   => $units['SFT'],
                                    ],
                                ],
                            ],
                            [ // M.S Vertical Louver Work
                                'name'          => 'M.S Vertical Louver Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],

                            ],
                        ],
                    ],
                    [ // FALSE CEILING WORK
                        'name'          => 'FALSE CEILING WORK',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                        'children'      => [
                            [ // FALSE CEILING AT COMMON AREA BY WOOD
                                'name'          => 'AT COMMON AREA BY WOOD',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                            ],
                        ],
                    ],
                    [ // Glazing Shutter

                        'name'          => 'Glazing Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                        'children'      => [
                            [
                                'name'          => 'By uPVC Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                                'children'      => [
                                    [
                                        'name'          => '4" Fixed/Sliding Work',
                                        'material_unit' => $units['SFT'],
                                        'labour_unit'   => $units['SFT'],
                                    ],
                                    [
                                        'name'          => '3" Fixed/Sliding Work',
                                        'material_unit' => $units['SFT'],
                                        'labour_unit'   => $units['SFT'],
                                    ],
                                    [
                                        'name'          => '3" Sliding Casement Work',
                                        'material_unit' => $units['SFT'],
                                        'labour_unit'   => $units['SFT'],
                                    ],
                                ],
                            ],
                            [
                                'name'          => 'By Thai Aluminum Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                                'children'      => [
                                    [
                                        'name'          => '4" Fixed/Sliding Work',
                                        'material_unit' => $units['SFT'],
                                        'labour_unit'   => $units['SFT'],
                                    ],
                                    [
                                        'name'          => '3" Fixed/Sliding Work',
                                        'material_unit' => $units['SFT'],
                                        'labour_unit'   => $units['SFT'],
                                    ],
                                    [
                                        'name'          => '3" Sliding Casement Work',
                                        'material_unit' => $units['SFT'],
                                        'labour_unit'   => $units['SFT'],
                                    ],
                                ],
                            ],
                            [
                                'name'          => 'By Glass Curtain Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                                'children'      => [
                                    [
                                        'name'          => '4" X 2" Fixed Work',
                                        'material_unit' => $units['SFT'],
                                        'labour_unit'   => $units['SFT'],
                                    ],
                                    [
                                        'name'          => 'Casement Work',
                                        'material_unit' => $units['SFT'],
                                        'labour_unit'   => $units['SFT'],
                                    ],
                                    [
                                        'name'          => 'Curtain Glass Door Work',
                                        'material_unit' => $units['SFT'],
                                        'labour_unit'   => $units['SFT'],
                                    ],
                                ],
                            ],
                            [
                                'name'          => 'Veranda Glass Railing Work',
                                'material_unit' => $units['SFT'],
                                'labour_unit'   => $units['SFT'],
                            ],
                        ],
                    ],
                ],
            ])->floorTypes()->attach($getTypeId('basement', 'ground', 'floor', 'roof'));

            // Painting Work
            BoqWork::create([
                'name'          => 'Painting Work',
                'material_unit' => $units['SFT'],
                'labour_unit'   => $units['SFT'],
                'children'      => [
                    [
                        'name'          => 'Inside Painting Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                    [
                        'name'          => 'Outside Painting Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                    [
                        'name'          => 'Enamel Painting Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                    [
                        'name'          => 'Epoxy Painting Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                ],
            ])->floorTypes()->attach($getTypeId('basement', 'ground', 'floor', 'roof', 'boundary wall'));

            // Polish Work
            BoqWork::create([
                'name'          => 'Polish Work',
                'material_unit' => $units['SFT'],
                'labour_unit'   => $units['SFT'],
            ])->floorTypes()->attach($getTypeId('basement', 'ground', 'floor', 'roof', 'boundary wall'));

            // Miscellaneous Work
            BoqWork::create([
                'name'          => 'Miscellaneous Work',
                'material_unit' => $units['SFT'],
                'labour_unit'   => $units['SFT'],
                'children'      => [
                    [
                        'name'          => 'Vertical Garden Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                    [
                        'name'          => 'Col Guard Work',
                        'material_unit' => $units['NO'],
                        'labour_unit'   => $units['NO'],
                    ],
                    [
                        'name'          => 'Wheel Guard Work',
                        'material_unit' => $units['NO'],
                        'labour_unit'   => $units['NO'],
                    ],
                    [
                        'name'          => 'Horizontal Garden Work',
                        'material_unit' => $units['SFT'],
                        'labour_unit'   => $units['SFT'],
                    ],
                    [
                        'name'          => 'M.S ladder Work',
                        'material_unit' => $units['NO'],
                        'labour_unit'   => $units['NO'],
                    ],
                ],
            ])->floorTypes()->attach($getTypeId('basement', 'ground', 'floor', 'roof', 'boundary wall'));
        });
    }
}
