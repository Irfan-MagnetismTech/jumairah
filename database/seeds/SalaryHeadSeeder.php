<?php

namespace Database\Seeders;

use App\Accounts\SalaryHead;
use Illuminate\Database\Seeder;

class SalaryHeadSeeder extends Seeder
{
    public function run()
    {
        $heads = ['Sales','Revenue','Accounts','Human Resource'];
        SalaryHead::truncate();
        foreach($heads as $head){
            SalaryHead::create(['name' => $head]);
        }
    }
}
