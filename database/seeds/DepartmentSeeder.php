<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = ['Sales','Revenue','Accounts','Human Resource'];
        foreach($departments as $department){
            \App\Department::create(['name' => $department]);
        }
    }
}
