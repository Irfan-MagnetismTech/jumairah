<?php

use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = ['Barishal','Chattogram','Dhaka','Khulna','Rajshahi','Rangpur','Sylhet','Mymensingh'];
        foreach($divisions as $division){
            \App\Division::create(['name'=>$division]);
        }
    }
}
