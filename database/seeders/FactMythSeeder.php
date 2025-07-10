<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FactMythSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'question' => 'Apakah anemia hanya karena kurang makan?',
                'is_fact' => false,
                'explanation' => 'Anemia bisa disebabkan oleh kekurangan zat besi, kehilangan darah, gangguan penyerapan nutrisi, atau penyakit kronis.',
                'correct_label' => 'Mitos',
                'category' => 'Anemia',
            ],
            [
                'question' => 'Benarkah hanya orang kurus yang bisa terkena anemia?',
                'is_fact' => false,
                'explanation' => 'Siapa saja bisa mengalami anemia, baik kurus maupun gemuk.',
                'correct_label' => 'Mitos',
                'category' => 'Anemia',
            ],
            [
                'question' => 'Apakah wajah pucat pasti tanda anemia?',
                'is_fact' => false,
                'explanation' => 'Wajah pucat bisa menjadi salah satu gejala anemia, tapi harus didukung pemeriksaan kadar Hb (hemoglobin) untuk memastikannya.',
                'correct_label' => 'Mitos',
                'category' => 'Anemia',
            ],
            [
                'question' => 'Apakah tablet tambah darah bisa bikin gemuk?',
                'is_fact' => false,
                'explanation' => 'Tablet tambah darah tidak menyebabkan kegemukan. Justru membantu tubuh lebih bertenaga dan sehat.',
                'correct_label' => 'Mitos',
                'category' => 'Anemia',
            ],
            [
                'question' => 'Apakah anemia tidak berbahaya?',
                'is_fact' => false,
                'explanation' => 'Anemia yang dibiarkan bisa berdampak serius, seperti lemas berkepanjangan, gangguan konsentrasi, bahkan komplikasi kehamilan.',
                'correct_label' => 'Mitos',
                'category' => 'Anemia',
            ],
            [
                'question' => 'Benarkah tablet tambah darah bikin badan gemuk?',
                'is_fact' => false,
                'explanation' => 'Tablet ini tidak mengandung kalori tinggi. Berat badan naik biasanya karena pola makan yang salah, bukan karena tablet tambah darah.',
                'correct_label' => 'Mitos',
                'category' => 'Anemia',
            ],
            [
                'question' => 'Apakah tablet tambah darah hanya untuk orang sakit?',
                'is_fact' => false,
                'explanation' => 'Tablet ini juga diberikan untuk pencegahan, terutama bagi remaja putri dan ibu hamil.',
                'correct_label' => 'Mitos',
                'category' => 'Anemia',
            ],
            [
                'question' => 'Apakah tablet tambah darah bikin mual dan bau?',
                'is_fact' => true,
                'explanation' => 'Efek samping ringan seperti mual bisa terjadi di awal, tapi bisa dikurangi dengan minum setelah makan. Baunya aman dan normal.',
                'correct_label' => 'Fakta',
                'category' => 'Anemia',
            ],
            [
                'question' => 'Apakah cukup makan sayur dan daging tanpa perlu tablet tambah darah?',
                'is_fact' => false,
                'explanation' => 'Makanan bergizi penting, tapi asupan zat besi dari makanan saja kadang tidak cukup, terutama saat menstruasi atau hamil.',
                'correct_label' => 'Mitos',
                'category' => 'Anemia',
            ],
            [
                'question' => 'Apakah tablet tambah darah bisa menyebabkan ketergantungan?',
                'is_fact' => false,
                'explanation' => 'Tablet ini tidak membuat ketergantungan. Jika kadar zat besi normal dan kebutuhan tercukupi, tubuh tidak akan menyerap lebih dari dibutuhkan.',
                'correct_label' => 'Mitos',
                'category' => 'Anemia',
            ]
        ];

        foreach ($data as $item) {
            DB::table('fact_myths')->insert(array_merge($item, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]));
        }
    }
}
