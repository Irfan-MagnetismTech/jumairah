<?php

use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks =  [
            ['name' => 'Aslami Bank Bangladesh Limited','account_name'=>'Kabir','account_number'=>1234567230,'swift_code'=>'BDGHJTUYI', 'routing_number'=>'100120', 'branch_name'=>'Head Office'],
            ['name' => 'Sonali Bank Limited','account_name'=>'Karim','account_number'=>1234567110,'swift_code'=>'BDGDFAADS', 'routing_number'=>'100120', 'branch_name'=>'Head Office'],
            ['name' => 'Dutch-Bangla Bank Limited','account_name'=>'Kabira','account_number'=>1234567890,'swift_code'=>'BDFKJFDD', 'routing_number'=>'100120', 'branch_name'=>'Head Office'],
        ];
        foreach($banks as $bank){
            \App\Bank::create($bank);
        }
    }
}
