<?php

namespace Database\Seeders;

use App\Mouza;
use Illuminate\Database\Seeder;

class MouzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mouzas = [
            ["thana_id" => 73, "name" => "Anowara"],
            ["thana_id" => 73, "name" => "Ayr Mangal"],
            ["thana_id" => 73, "name" => "Barasat"],
            ["thana_id" => 73, "name" => "Belchura"],
            ["thana_id" => 73, "name" => "Boalgaon"],
            ["thana_id" => 73, "name" => "Boalia"],
            ["thana_id" => 73, "name" => "Boirag"],
            ["thana_id" => 73, "name" => "Bot Tali"],
            ["thana_id" => 73, "name" => "Chapatali"],
            ["thana_id" => 73, "name" => "Chatari"],
            ["thana_id" => 73, "name" => "Chunnapara"],
            ["thana_id" => 73, "name" => "Daksin Paruapara"],
            ["thana_id" => 73, "name" => "Dhanpura"],
            ["thana_id" => 73, "name" => "Dudkomra"],
            ["thana_id" => 73, "name" => "Dudkomra"],
            ["thana_id" => 73, "name" => "Dumuria"],

        ];
        foreach ($mouzas as $mouza) {
            Mouza::create($mouza);
        }
    }
}
