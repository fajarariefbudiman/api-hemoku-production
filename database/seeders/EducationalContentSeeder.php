<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationalContentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('educational_contents')->insert([
            [
                'title' => 'Mengenal Gejala Anemia pada Remaja',
                'type' => 'artikel',
                'section' => 'Kementerian Kesehatan',
                'description' => 'Artikel Kemenkes tentang tanda-tanda anemia remaja.',
                'content' => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sed fugiat magni vel autem quibusdam optio eius iusto, tenetur a. Ipsa voluptatibus culpa laborum iusto odit porro? Officiis in incidunt veritatis.",
                'url' => 'https://ayosehat.kemkes.go.id/mengenal-gejala-anemia-pada-remaja',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Anemia Symptoms',
                'type' => 'poster',
                'section' => 'Poster',
                'description' => 'Poster edukasi tentang Anemia Symptoms',
                'content' => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sed fugiat magni vel autem quibusdam optio eius iusto, tenetur a. Ipsa voluptatibus culpa laborum iusto odit porro? Officiis in incidunt veritatis.",
                'url' => '/storage/posters/poster1.jpg',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tanda Anak Kekurangan Zat Besi',
                'type' => 'poster',
                'section' => 'Poster',
                'description' => 'Poster edukasi tentang kekurangan zat besi',
                'content' => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sed fugiat magni vel autem quibusdam optio eius iusto, tenetur a. Ipsa voluptatibus culpa laborum iusto odit porro? Officiis in incidunt veritatis.",
                'url' => '/storage/posters/poster2.jpg',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Video Edukasi Tablet Tambah Darah',
                'type' => 'video',
                'section' => 'Video Edukasi',
                'description' => 'Video dari Kemenkes RI tentang anemia remaja.',
                'content' => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sed fugiat magni vel autem quibusdam optio eius iusto, tenetur a. Ipsa voluptatibus culpa laborum iusto odit porro? Officiis in incidunt veritatis.",
                'url' => 'https://www.youtube.com/embed/CRCJ5ibZSiw?si=eonE4S47erAP05QI',
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
