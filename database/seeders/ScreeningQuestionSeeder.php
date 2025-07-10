<?php

namespace Database\Seeders;

use App\Models\ScreeningQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScreeningQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'question' => 'Apakah kamu sering merasa sangat lelah atau lemah?',
                'category' => 'Energi',
                'weight' => 1,
            ],
            [
                'question' => 'Apakah kamu mengalami pusing atau kunang-kunang?',
                'category' => 'Sirkulasi',
                'weight' => 1,
            ],
            [
                'question' => 'Apakah kamu sesak napas saat aktivitas ringan?',
                'category' => 'Pernapasan',
                'weight' => 1,
            ],
            [
                'question' => 'Apakah tangan dan kakimu sering dingin?',
                'category' => 'Sirkulasi',
                'weight' => 1,
            ],
            [
                'question' => 'Adakah yang bilang kulitmu terlihat lebih pucat?',
                'category' => 'Kulit',
                'weight' => 1,
            ],
        ];

        foreach ($questions as $question) {
            ScreeningQuestion::create($question);
        }
    }
}
