<?php

use Illuminate\Database\Seeder;

class ApsectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections = [
           ['name' => 'Grease'], //1
           ['name' => 'Lube'], //2
           ['name' => 'Trading'], //3
        ];
        foreach($sections as $section){
            \App\Apsection::create($section);
        }

    }
}
