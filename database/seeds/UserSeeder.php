<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users =[
            [
            'name' => 'super-admin',
            'email' => 'sadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$nBcFmdKHFT/R5X.ntbJTjuYke7gEabhg55CJTCanOwUzkpOyZfhB2', // sadmin@gmail.com
            'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$7fDmrBziQ2iz1N8IsNqZ4uAHcJHm/3d.wy4QWfmpv/6gyh5gDeZNG', // admin@gmail.com
                'remember_token' => Str::random(10),
            ]
        ];

        foreach($users as $user){
            $userId =  \App\User::create($user);
            $role = \App\Role::where('name', 'super-admin')->first();
            $userId->assignRole($role->id);
        }

    }
}
