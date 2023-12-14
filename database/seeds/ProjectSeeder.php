<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects =  [
            ['name'=>'ISPAHANI HILL CREST','location'=>'Nasirabad Properties Ltd., South Khulshi, CTG','category'=>'Residential','storied'=>9,'signing_date'=>'01-04-2021', 'cda_approval_date'=>'04-04-2021', 'innogration_date'=>'07-05-2021', 'handover_date'=>'10-05-2021', 'project_cost'=>10000000, 'landsize'=>11000, 'buildup_area'=>10000, 'sellable_area'=>8000,'units'=>20,'parking'=>30,'landowner_share'=>50,'developer_share'=>50,'landowner_unit'=>5,'developer_unit'=>5,'landowner_parking'=>10,'developer_parking'=>10,'lO_sellable_area'=>50,'developer_sellable_area'=>100,'landowner_cash_benefit'=>100000],
            ['name'=>'QUEENS PARK','location'=>'Nasirabad Properties Ltd., South Khulshi, Chattogram','category'=>'Residential','storied'=>15,'signing_date'=>'01-04-2021', 'cda_approval_date'=>'04-04-2021', 'innogration_date'=>'07-05-2021', 'handover_date'=>'10-05-2021', 'project_cost'=>10000000, 'landsize'=>11000, 'buildup_area'=>10000, 'sellable_area'=>8000,'units'=>20,'parking'=>30,'landowner_share'=>50,'developer_share'=>50,'landowner_unit'=>5,'developer_unit'=>5,'landowner_parking'=>10,'developer_parking'=>10,'lO_sellable_area'=>50,'developer_sellable_area'=>100,'landowner_cash_benefit'=>100000],
            ['name'=>'KHAN PLAZA','location'=>'Sk. Mujib Road, Chowmuhani, Chattogram','category'=>'Commercial','storied'=>10,'signing_date'=>'01-04-2021', 'cda_approval_date'=>'04-04-2021', 'innogration_date'=>'07-05-2021', 'handover_date'=>'10-05-2021', 'project_cost'=>10000000, 'landsize'=>11000, 'buildup_area'=>10000, 'sellable_area'=>8000,'units'=>20,'parking'=>30,'landowner_share'=>50,'developer_share'=>50,'landowner_unit'=>5,'developer_unit'=>5,'landowner_parking'=>10,'developer_parking'=>10,'lO_sellable_area'=>50,'developer_sellable_area'=>100,'landowner_cash_benefit'=>100000],
            ['name'=>'CASA CROWN','location'=>'House 19, Road 6, Nasirabad H/S, Chattogram','category'=>'Residential','storied'=>25,'signing_date'=>'01-04-2021', 'cda_approval_date'=>'04-04-2021', 'innogration_date'=>'07-05-2021', 'handover_date'=>'10-05-2021', 'project_cost'=>10000000, 'landsize'=>11000, 'buildup_area'=>10000, 'sellable_area'=>8000,'units'=>20,'parking'=>30,'landowner_share'=>50,'developer_share'=>50,'landowner_unit'=>5,'developer_unit'=>5,'landowner_parking'=>10,'developer_parking'=>10,'lO_sellable_area'=>50,'developer_sellable_area'=>100,'landowner_cash_benefit'=>100000],
            ['name'=>'White Oak','location'=>'Shahid Mirza Lane (West), Mehedibag, Chattogram','category'=>'Residential cum Commercial','storied'=>20,'signing_date'=>'01-04-2021', 'cda_approval_date'=>'04-04-2021', 'innogration_date'=>'07-05-2021', 'handover_date'=>'10-05-2021', 'project_cost'=>10000000, 'landsize'=>11000, 'buildup_area'=>10000, 'sellable_area'=>8000,'units'=>20,'parking'=>30,'landowner_share'=>50,'developer_share'=>50,'landowner_unit'=>5,'developer_unit'=>5,'landowner_parking'=>10,'developer_parking'=>10,'lO_sellable_area'=>50,'developer_sellable_area'=>100,'landowner_cash_benefit'=>100000],

        ];
        foreach($projects as $project){
            Project::create($project);
        }
    }
}
