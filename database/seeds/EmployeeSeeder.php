<?php

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [
            ['designation_id'=>1,'department_id'=>1,'fname'=>'Kabir','lname'=>'Hossain','email'=>'kabir@gmail.com','pre_thana_id'=>85, 'per_thana_id'=>85],
            ['designation_id'=>2,'department_id'=>2,'fname'=>'Jamal','lname'=>'Hossain','email'=>'jamal@gmail.com','pre_thana_id'=>258, 'per_thana_id'=>258],
            ['designation_id'=>3,'department_id'=>3,'fname'=>'Rahim','lname'=>'Hossain','email'=>'rahim@gmail.com','pre_thana_id'=>17, 'per_thana_id'=>17],
            ['designation_id'=>4,'department_id'=>4,'fname'=>'Iqbal','lname'=>'Hossain','email'=>'iqbal@gmail.com','pre_thana_id'=>70, 'per_thana_id'=>70],
        ];
        foreach($employees as $employee){
            \App\Employee::create($employee);
        }
    }
}
