<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubtestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subtests')->insert([
            [
                'formula_id' => 1,
                'subtest_name' => 'Logical Reasoning',
                'is_active' => 1,
                'created_by' => 'admin',
                'created_time' => now(),
                'updated_by' => 'admin',
                'updated_time' => now(),
                'deleted_by' => null,
                'deleted_time' => null,
            ],
            [
                'formula_id' => 2,
                'subtest_name' => 'Verbal Reasoning',
                'is_active' => 1,
                'created_by' => 'admin',
                'created_time' => now(),
                'updated_by' => 'admin',
                'updated_time' => now(),
                'deleted_by' => null,
                'deleted_time' => null,
            ],
            [
                'formula_id' => 3,
                'subtest_name' => 'Numerical Reasoning',
                'is_active' => 1,
                'created_by' => 'admin',
                'created_time' => now(),
                'updated_by' => 'admin',
                'updated_time' => now(),
                'deleted_by' => null,
                'deleted_time' => null,
            ],
            [
                'formula_id' => 4,
                'subtest_name' => 'Technical Skills',
                'is_active' => 1,
                'created_by' => 'admin',
                'created_time' => now(),
                'updated_by' => 'admin',
                'updated_time' => now(),
                'deleted_by' => null,
                'deleted_time' => null,
            ],
            [
                'formula_id' => 5,
                'subtest_name' => 'Behavioral Assessment',
                'is_active' => 1,
                'created_by' => 'admin',
                'created_time' => now(),
                'updated_by' => 'admin',
                'updated_time' => now(),
                'deleted_by' => null,
                'deleted_time' => null,
            ],
        ]);
    }
}
