<?php

namespace Database\Seeders;

use App\Models\ScreeningSessions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScreeningSessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScreeningSessions::insert([
            [
                'user_id' => 1,
                'score' => 1,
                'risk_level' => 'rendah',
                'risk_description' => 'Kondisimu terlihat baik! Pertahankan kebiasaan sehatmu.',
                'next_step' => 'Jelajahi bagian Nutrisi kami untuk resep kaya zat besi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'score' => 3,
                'risk_level' => 'sedang',
                'risk_description' => 'Kamu memiliki beberapa gejala. Ada baiknya memperhatikan diet dan tingkat energimu.',
                'next_step' => 'Lihat \'Fakta vs Mitos\' di hub Edukasi kami untuk belajar lebih banyak.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'score' => 5,
                'risk_level' => 'tinggi',
                'risk_description' => 'Kamu menunjukkan beberapa gejala utama. Kami sarankan untuk berbicara dengan orang tua atau dokter.',
                'next_step' => 'Kunjungi bagian \'Apa itu Anemia?\' di hub Edukasi kami untuk info lebih lanjut.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
