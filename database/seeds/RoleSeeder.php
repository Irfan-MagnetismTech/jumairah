<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['super-admin','admin','user','manager', 'authority'];
        foreach($roles as $role){
            \App\Role::create(['name'=>$role,'guard_name'=>'web']);
        }
    }
}
