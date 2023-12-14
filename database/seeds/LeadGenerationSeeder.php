<?php

namespace Database\Seeders;

use App\Sells\LeadGeneration;
use Illuminate\Database\Seeder;

class LeadGenerationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leadgenerations =  [
            ['name'=>'Anwarul Azim','contact'=>'01719986171','profession'=>'Business','present_address'=>'Agrabad, Chattogram', 'permanent_address'=>'Boshurhat, Nowakhali', 'nationality'=>'Bangladeshi', 'lead_date'=>'10-05-2021', 'lead_stage'=>'Sold', 'source_type'=>'Friend', 'apartment_id'=>'1'],
            ['name'=>'Nurul Azim','contact'=>'01719986175','profession'=>'Service','present_address'=>'Eidgah, Chattogram', 'permanent_address'=>'Monpura, Nowakhali', 'nationality'=>'Bangladeshi', 'lead_date'=>'11-05-2021', 'lead_stage'=>'High Priority', 'source_type'=>'Relative', 'apartment_id'=>'2'],
            ['name'=>'Noor Nabi','contact'=>'01719986174','profession'=>'Goverment Service','present_address'=>'Chowmohuni, Chattogram', 'permanent_address'=>'Hatia, Nowakhali', 'nationality'=>'Bangladeshi', 'lead_date'=>'12-05-2021', 'lead_stage'=>'Sold', 'source_type'=>'Marketing', 'apartment_id'=>'3'],
            ['name'=>'Ali Abbas','contact'=>'01719986173','profession'=>'Engineer','present_address'=>'Dewanhat, Chattogram', 'permanent_address'=>'Ramgoti, Nowakhali', 'nationality'=>'Bangladeshi', 'lead_date'=>'13-05-2021', 'lead_stage'=>'High Priority', 'source_type'=>'Friend', 'apartment_id'=>'4'],
            ['name'=>'Abdul Kader','contact'=>'01719986172','profession'=>'Doctor','present_address'=>'Kulshi, Chattogram', 'permanent_address'=>'Senbag, Nowakhali', 'nationality'=>'Bangladeshi', 'lead_date'=>'14-05-2021', 'lead_stage'=>'Sold', 'source_type'=>'Marketing', 'apartment_id'=>'5'],

        ];
        foreach($leadgenerations as $leadGeneration){
            LeadGeneration::create($leadGeneration);
        }
    }
}
