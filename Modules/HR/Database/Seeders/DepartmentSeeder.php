<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ====== Golden Ispat
        $csvFileGil = 'Modules/HR/Database/Seeders/Data/departments-gil.csv';

        $headerLine = true;
        $delimiter = ',';

        if (($handle = fopen($csvFileGil, 'r')) !== false) {

            while (($data = fgetcsv($handle, 1000, $delimiter)) !== false) {
                // if ($headerLine) {
                //     $headerLine = false;
                //     continue;
                // }

                DB::table('departments')->insert([
                    'name' => $data[0],
                    'com_id' => "feb4b55f-df58-4aff-8ec2-5cbc12c8e029",
                ]);
            }

            fclose($handle);
        }


        // ====== HM Steel
        $csvFileHm = 'Modules/HR/Database/Seeders/Data/departments-hm.csv';

        $headerLine = true;
        $delimiter = ',';

        if (($handle = fopen($csvFileHm, 'r')) !== false) {

            while (($data = fgetcsv($handle, 1000, $delimiter)) !== false) {
                // if ($headerLine) {
                //     $headerLine = false;
                //     continue;
                // }

                DB::table('departments')->insert([
                    'name' => $data[0],
                    'com_id' => "6fa50914-e296-49c5-b43b-3b73650ee807",
                ]);
            }

            fclose($handle);
        }
    }
}
