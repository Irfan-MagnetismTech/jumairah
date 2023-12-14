<?php

namespace Database\Seeders;

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name'=>'permission-create', 'guard_name'=>'web'],
            ['name'=>'permission-view', 'guard_name'=>'web'],
            ['name'=>'permission-edit', 'guard_name'=>'web'],
            ['name'=>'permission-delete', 'guard_name'=>'web'],

            ['name'=>'role-create', 'guard_name'=>'web'],
            ['name'=>'role-view', 'guard_name'=>'web'],
            ['name'=>'role-edit', 'guard_name'=>'web'],
            ['name'=>'role-delete', 'guard_name'=>'web'],

            ['name'=>'user-create', 'guard_name'=>'web'],
            ['name'=>'user-view', 'guard_name'=>'web'],
            ['name'=>'user-edit', 'guard_name'=>'web'],
            ['name'=>'user-delete', 'guard_name'=>'web'],

            ['name'=>'department-create', 'guard_name'=>'web'],
            ['name'=>'department-view', 'guard_name'=>'web'],
            ['name'=>'department-edit', 'guard_name'=>'web'],
            ['name'=>'department-delete', 'guard_name'=>'web'],

            ['name'=>'designation-create', 'guard_name'=>'web'],
            ['name'=>'designation-view', 'guard_name'=>'web'],
            ['name'=>'designation-edit', 'guard_name'=>'web'],
            ['name'=>'designation-delete', 'guard_name'=>'web'],

            ['name'=>'employee-create', 'guard_name'=>'web'],
            ['name'=>'employee-view', 'guard_name'=>'web'],
            ['name'=>'employee-edit', 'guard_name'=>'web'],
            ['name'=>'employee-delete', 'guard_name'=>'web'],

            ['name'=>'project-view', 'guard_name'=>'web'],
            ['name'=>'project-create', 'guard_name'=>'web'],
            ['name'=>'project-edit', 'guard_name'=>'web'],
            ['name'=>'project-delete', 'guard_name'=>'web'],

            ['name'=>'team-view', 'guard_name'=>'web'],
            ['name'=>'team-create', 'guard_name'=>'web'],
            ['name'=>'team-edit', 'guard_name'=>'web'],
            ['name'=>'team-delete', 'guard_name'=>'web'],

            ['name'=>'parking-view', 'guard_name'=>'web'],
            ['name'=>'parking-create', 'guard_name'=>'web'],
            ['name'=>'parking-edit', 'guard_name'=>'web'],
            ['name'=>'parking-delete', 'guard_name'=>'web'],

            ['name'=>'apartment-view', 'guard_name'=>'web'],
            ['name'=>'apartment-create', 'guard_name'=>'web'],
            ['name'=>'apartment-edit', 'guard_name'=>'web'],
            ['name'=>'apartment-delete', 'guard_name'=>'web'],

            ['name'=>'leadgeneration-view', 'guard_name'=>'web'],
            ['name'=>'leadgeneration-create', 'guard_name'=>'web'],
            ['name'=>'leadgeneration-edit', 'guard_name'=>'web'],
            ['name'=>'leadgeneration-delete', 'guard_name'=>'web'],

            ['name'=>'client-view', 'guard_name'=>'web'],
            ['name'=>'client-create', 'guard_name'=>'web'],
            ['name'=>'client-edit', 'guard_name'=>'web'],
            ['name'=>'client-delete', 'guard_name'=>'web'],

            ['name'=>'sell-view', 'guard_name'=>'web'],
            ['name'=>'sell-create', 'guard_name'=>'web'],
            ['name'=>'sell-edit', 'guard_name'=>'web'],
            ['name'=>'sell-delete', 'guard_name'=>'web'],

            ['name'=>'salesCollection-view', 'guard_name'=>'web'],
            ['name'=>'salesCollection-create', 'guard_name'=>'web'],
            ['name'=>'salesCollection-edit', 'guard_name'=>'web'],
            ['name'=>'salesCollection-delete', 'guard_name'=>'web'],

            ['name'=>'sellCollectionHead-view', 'guard_name'=>'web'],
            ['name'=>'sellCollectionHead-create', 'guard_name'=>'web'],
            ['name'=>'sellCollectionHead-edit', 'guard_name'=>'web'],
            ['name'=>'sellCollectionHead-delete', 'guard_name'=>'web'],


            // Followup, SalesCollectionApproval ,To-do-list should be added

        ];

        foreach($permissions as $permission){
            Permission::create($permission);
        }

    }
}
