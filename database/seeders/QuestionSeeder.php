<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questions')->insert([
            [
                'subtest_id' => 1,
                'is_grup' => 0,
                'question_name' => 'What comes next in the sequence? 2, 4, 8, 16, ...',
                'question_detail' => 'Determine the pattern and find the next number in the sequence.',
                'is_active' => 1,
                'created_by' => 'admin',
                'created_time' => now(),
                'updated_by' => 'admin',
                'updated_time' => now(),
                'deleted_by' => null,
                'deleted_time' => null,
            ],
            [
                'subtest_id' => 2,
                'is_grup' => 0,
                'question_name' => 'Which word is a synonym for "happy"?',
                'question_detail' => 'Choose the word that best matches the meaning of "happy".',
                'is_active' => 1,
                'created_by' => 'admin',
                'created_time' => now(),
                'updated_by' => 'admin',
                'updated_time' => now(),
                'deleted_by' => null,
                'deleted_time' => null,
            ],
            [
                'subtest_id' => 3,
                'is_grup' => 0,
                'question_name' => 'Solve: 15 + 27 = ?',
                'question_detail' => 'Find the sum of 15 and 27.',
                'is_active' => 1,
                'created_by' => 'admin',
                'created_time' => now(),
                'updated_by' => 'admin',
                'updated_time' => now(),
                'deleted_by' => null,
                'deleted_time' => null,
            ],
            [
                'subtest_id' => 4,
                'is_grup' => 0,
                'question_name' => 'What does HTTP stand for?',
                'question_detail' => 'Select the correct full form of HTTP.',
                'is_active' => 1,
                'created_by' => 'admin',
                'created_time' => now(),
                'updated_by' => 'admin',
                'updated_time' => now(),
                'deleted_by' => null,
                'deleted_time' => null,
            ],
            [
                'subtest_id' => 5,
                'is_grup' => 0,
                'question_name' => 'How do you handle stress?',
                'question_detail' => 'Describe your approach to managing stress in the workplace.',
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
