<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsSeeder extends Seeder
{
    public function run()
    {
        DB::table('questions')->insert([
            [
                'question_text' => 'What is the capital of France?',
                'option_a' => 'Berlin',
                'option_b' => 'Madrid',
                'option_c' => 'Paris',
                'option_d' => 'Rome',
                'correct_option' => 'C'
            ],
            [
                'question_text' => 'Which language is used for web development?',
                'option_a' => 'Python',
                'option_b' => 'JavaScript',
                'option_c' => 'C++',
                'option_d' => 'Swift',
                'correct_option' => 'B'
            ],
            [
                'question_text' => 'What does CPU stand for?',
                'option_a' => 'Central Processing Unit',
                'option_b' => 'Computer Personal Unit',
                'option_c' => 'Central Personal Unit',
                'option_d' => 'Central Process Utility',
                'correct_option' => 'A'
            ],
        ]);
    }
}

