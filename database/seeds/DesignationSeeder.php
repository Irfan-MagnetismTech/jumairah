<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = [
            ['name'=>'Manager'],
            ['name'=>'Asst. Manager'],
            ['name'=>'Sr. Executive'],
        ];
        foreach($designations as $designation){
            \App\Designation::create($designation);
        }
    }
}
