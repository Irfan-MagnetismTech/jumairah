<?php

use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //foreigner
        $suppliers = [
            ['type'=>'foreign', 'country'=>'Singapore', 'name'=>'Chemlube S.A.','contact'=>'0182987655','email'=>'abc@gmail.com','address'=>'5203 Center Blvd, Long Island City, NY 11101'],
            ['type'=>'foreign', 'country'=>'Singapore', 'name'=>'AP Oil Pte. Ltd.','contact'=>'0182982655','email'=>'abj@gmail.com','address'=>'5203 Center Blvd, Long Island City, NY 11101'],

            ['type'=>'local', 'country'=>null, 'name'=>'New Burkhan Perfumery','contact'=>'0182007655','email'=>'abk@gmail.com','address'=>'Chittagong'],
            ['type'=>'local', 'country'=>null, 'name'=>'Bangladesh Colours Chem. Corporation','contact'=>'0182087655','email'=>'abe@gmail.com','address'=>'Chittagong'],
            ['type'=>'local', 'country'=>null, 'name'=>'Chan Traders','contact'=>'0182387655','email'=>'auc@gmail.com','address'=>'Chittagong'],
            ['type'=>'local', 'country'=>null, 'name'=>'Ahmed Perfumers','contact'=>'0180987655','email'=>'alc@gmail.com','address'=>'Chittagong'],
            ['type'=>'local', 'country'=>null, 'name'=>'Potiya','contact'=>'0184987655','email'=>'aac@gmail.com','address'=>'Chittagong'],
        ];

        foreach ($suppliers as $supplier){
           \App\Procurement\Supplier::create($supplier);
        }
    }
}
