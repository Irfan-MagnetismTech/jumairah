<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Config\LeayerName;

class LeayerNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leayer_names =  [
            [
              'name' => 'Sale Cancellation',
            ],
            [
              'name' => 'Requisiton',
            ],
            [
              'name' => 'CS',
            ],
            [
              'name' => 'Material Receive Report',
            ],
            [
              'name' => 'Supplier Bill',
            ],
            [
              'name' => 'Store Issue',
            ],
            [
              'name' => 'IOU',
            ],
            [
              'name' => 'Advance Adjustment',
            ],
            [
              'name' => 'Movement Requisition',
            ],
            [
              'name' => 'Movement Out',
            ],
            [
              'name' => 'Movement In',
            ],
            [
              'name' => 'Allocation',
            ],
            [
              'name' => 'Material Plan',
            ],
            [
              'name' => 'Final Costing',
            ],
            [
              'name' => 'Name Transfer',
            ],
            [
              'name' => 'Requisition IEC',
            ],
            [
              'name' => 'Requisition ICC',
            ],
            [
              'name' => 'Requisition IC',
            ],
            [
              'name' => 'Requisition (General)',
            ],
          ];

          LeayerName::insert($leayer_names);
    }
}
