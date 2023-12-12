<?php

namespace Database\Seeders;

use App\ModuleSubject;
use Illuminate\Database\Seeder;

class moduleSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects =[
            [
                'module' => '',
                'subject' => '',
            ],

        ];

        foreach($subjects as $subject){
            $subjectData =  ModuleSubject::create($subject);
        }
    }
}
