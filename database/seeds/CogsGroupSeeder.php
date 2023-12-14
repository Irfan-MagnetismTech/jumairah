<?php

namespace Database\Seeders;

use App\CogsGroup;
use Illuminate\Database\Seeder;

class CogsGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            ['name' => 'Depreciation'],
            ['name' => 'Financial Expenses'],
            ['name' => 'Labor'],
            ['name' => 'Land & Land Development'],
            ['name' => 'Materials'],
            ['name' => 'Project Overhead'],
            ['name' => 'Salary, Allowance & Benefit'],

            ['name' => 'Division Fee'],
            ['name' => 'Management Fee'],
            ['name' => 'Sales & Marketing Exp'],
        ];

        foreach ($groups as $group){
            CogsGroup::create($group);
        }
    }
}
