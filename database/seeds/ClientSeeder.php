<?php

namespace Database\Seeders;

use App\Sells\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients =  [
            ['name'=>'Jahangir','company_name'=>'HKD Outdoor Innovations Ltd.', 'father_name'=>'X Hossain', 'mother_name'=>'Y Begum', 'dob'=>'01-04-1990', 'nationality'=>'Bangladeshi', 'occupation'=>'Services', 'present_address'=>'Amin Future Park, Agrabad', 'permanent_address'=>'Matiranga, Khagrachori', 'email'=>'jahangir@gmail.com','contact'=>'01817918171','contact_office'=>'01918716151','tin'=>'BD123456',],
            ['name'=>'Hasan Md. Shahriare','company_name'=>'QC Logistics Ltd.', 'father_name'=>'X Kamal', 'mother_name'=>'Y Akter', 'dob'=>'01-04-1990', 'nationality'=>'Bangladeshi', 'occupation'=>'Services', 'present_address'=>'Amin Future Park, Agrabad', 'permanent_address'=>'Matiranga, Khagrachori', 'email'=>'hasan@gmail.com','contact'=>'01817918171','contact_office'=>'01918716151','tin'=>'BD123456',],
            ['name'=>'Sumon Chandra','company_name'=>'Magnetism Tech Ltd.', 'father_name'=>'X Chandra', 'mother_name'=>'Y Chandra', 'dob'=>'01-04-1990', 'nationality'=>'Bangladeshi', 'occupation'=>'Services', 'present_address'=>'Amin Future Park, Agrabad', 'permanent_address'=>'Matiranga, Khagrachori', 'email'=>'sumon@gmail.com','contact'=>'01817918171','contact_office'=>'01918716151','tin'=>'BD123456',],
            ['name'=>'Syeda Saleha','company_name'=>'Chittagong Telecom Services ltd.', 'father_name'=>'X Chowdhury', 'mother_name'=>'XYZ', 'dob'=>'01-04-1990', 'nationality'=>'Bangladeshi', 'occupation'=>'Services', 'present_address'=>'Amin Future Park, Agrabad', 'permanent_address'=>'Matiranga, Khagrachori', 'email'=>'saleha@gmail.com','contact'=>'01817918171','contact_office'=>'01918716151','tin'=>'BD123456',],
        ];
        foreach($clients as $client){
            Client::create($client);
        }
    }
}
