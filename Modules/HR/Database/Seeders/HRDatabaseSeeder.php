<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\HR\Database\Seeders\CountryTableSeeder;
use Modules\HR\Entities\Employee;

class HRDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(CountryTableSeeder::class);
        // $this->call(DivisionTableSeeder::class);
        // $this->call(DistrictTableSeeder::class);



        //======================//==============//

        DB::table('departments')->truncate();
        //$this->call(DepartmentSeeder::class);

        DB::table('designations')->truncate();
        //$this->call(DesignationSeeder::class);

        DB::table('job_locations')->truncate();
        //$this->call(DesignationSeeder::class);


        $this->call(EmployeeSeeder::class);
    }
}


//  php artisan db:seed --class=Modules\HR\Database\Seeders\HRDatabaseSeeder
