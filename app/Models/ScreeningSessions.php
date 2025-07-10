<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreeningSessions extends Model
{
    /** @use HasFactory<\Database\Factories\ScreeningSessionsFactory> */
    use HasFactory;
    protected $fillable = ['user_id', 'score', 'risk_level', 'risk_description', 'next_step'];

    public function answers()
    {
        return $this->hasMany(ScreeningAnswer::class, 'session_id');
    }

    public static function evaluateRisk(int $score): array
    {
        if ($score <= 1) {
            return [
                'risk_level' => 'rendah',
                'risk_description' => 'Kondisimu terlihat baik! Pertahankan kebiasaan sehatmu.',
                'next_step' => 'Lihat \'Fakta vs Mitos\' di hub Edukasi kami untuk belajar lebih banyak.',
            ];
        }

        if ($score <= 3) {
            return [
                'risk_level' => 'sedang',
                'risk_description' => 'Kamu memiliki beberapa gejala. Ada baiknya memperhatikan diet dan tingkat energimu.',
                'next_step' => 'Lihat \'Fakta vs Mitos\' di hub Edukasi kami untuk belajar lebih banyak.',
            ];
        }

        return [
            'risk_level' => 'tinggi',
            'risk_description' => 'Kamu menunjukkan beberapa gejala utama. Kami sarankan untuk berbicara dengan orang tua atau dokter.',
            'next_step' => 'Kunjungi bagian \'Apa itu Anemia?\' di hub Edukasi kami untuk info lebih lanjut.',
        ];
    }
}
