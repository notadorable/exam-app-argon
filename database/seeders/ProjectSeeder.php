<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        DB::table('projects')->insert([
            [
                'project_name' => 'Job Application Test',
                'project_description' => 'This project involves a series of tests for job applicants.',
                'is_active' => 1,
                'created_by' => 1,
                'created_time' => Carbon::now(),
                'updated_by' => null,
                'updated_time' => null,
                'deleted_by' => null,
                'deleted_time' => null,
            ],
            [
                'project_name' => 'Internship Program Assessment',
                'project_description' => 'Assessing interns for the upcoming internship program.',
                'is_active' => 1,
                'created_by' => 1,
                'created_time' => Carbon::now(),
                'updated_by' => null,
                'updated_time' => null,
                'deleted_by' => null,
                'deleted_time' => null,
            ],
            [
                'project_name' => 'Employee Training Evaluation',
                'project_description' => 'Evaluation of employees during the training program.',
                'is_active' => 1,
                'created_by' => 1,
                'created_time' => Carbon::now(),
                'updated_by' => null,
                'updated_time' => null,
                'deleted_by' => null,
                'deleted_time' => null,
            ]
        ]);
    }
}
