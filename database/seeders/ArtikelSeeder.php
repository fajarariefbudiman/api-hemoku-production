<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $source = database_path('seeders/files/pdf');
        $destination = storage_path('app/public/pdf');

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        File::copyDirectory($source, $destination);

        DB::table('educational_contents')->insert([
            [
                'title' => 'Apa itu Anemia',
                'type' => 'artikel',
                'section' => 'artikel',
                'description' => 'Mengenalkan anemia secara umum, menjelaskan fungsi hemoglobin, serta dampak kekurangannya terhadap tubuh dan aktivitas sehari-hari.',
                'content' => 'Anemia adalah kondisi saat kadar hemoglobin (Hb) dalam darah lebih rendah dari nilai normal (WHO, 2011)...',
                'url' => '/storage/pdf/Apa-Itu-Anemia.pdf',
                'order' => 16,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Dampak Anemia',
                'type' => 'artikel',
                'section' => 'artikel',
                'description' => 'Menjelaskan bagaimana anemia mempengaruhi kualitas hidup remaja, termasuk prestasi belajar, produktivitas, dan masa depan mereka jika tidak ditangani.',
                'content' => 'Anemia bukan hanya soal tubuh yang lemah dan wajah yang pucat...',
                'url' => '/storage/pdf/Dampak-Anemia.pdf',
                'order' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Gejala Anemia',
                'type' => 'artikel',
                'section' => 'artikel',
                'description' => 'Menggambarkan tanda-tanda umum anemia yang sering tidak disadari, seperti lelah berlebihan, pusing, dan wajah pucat, serta pentingnya mengenali sejak dini.',
                'content' => 'Remaja merupakan kelompok rentan anemia...',
                'url' => '/storage/pdf/Gejala-Anemia.pdf',
                'order' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Jenis-Jenis Anemia',
                'type' => 'artikel',
                'section' => 'artikel',
                'description' => 'Menguraikan berbagai tipe anemia, termasuk penyebab dan karakteristiknya, untuk membantu masyarakat memahami bahwa anemia bukan hanya satu penyakit tunggal.',
                'content' => 'Anemia bukan hanya satu jenis penyakit...',
                'url' => '/storage/pdf/Jenis-Anemia.pdf',
                'order' => 19,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Klasifikasi Anemia',
                'type' => 'artikel',
                'section' => 'artikel',
                'description' => 'Menjelaskan tingkatan atau kategori anemia berdasarkan kadar hemoglobin dalam darah, serta risiko kesehatan yang menyertainya.',
                'content' => 'Anemia adalah kondisi ketika kadar hemoglobin (Hb) dalam darah menurun...',
                'url' => '/storage/pdf/Klasifikasi-Anemia.pdf',
                'order' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Penanganan Anemia',
                'type' => 'artikel',
                'section' => 'artikel',
                'description' => 'Memberikan panduan intervensi medis dan suplementasi zat besi (TTD) sesuai rekomendasi WHO sebagai cara efektif mengatasi anemia.',
                'content' => 'Untuk mengatasi dan mencegah kondisi ini, suplementasi tablet tambah darah (TTD)...',
                'url' => '/storage/pdf/Penanganan-Anemia.pdf',
                'order' => 21,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pencegahan Anemia',
                'type' => 'artikel',
                'section' => 'artikel',
                'description' => 'Menyediakan tips dan langkah konkret untuk mencegah anemia sejak dini, seperti pola makan bergizi, konsumsi TTD, dan pemantauan kesehatan.',
                'content' => 'Anemia bukan takdir, tapi bisa dicegah!...',
                'url' => '/storage/pdf/Pencegahan-Anemia.pdf',
                'order' => 22,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Penyebab Anemia',
                'type' => 'artikel',
                'section' => 'artikel',
                'description' => 'Menguraikan penyebab langsung dan tidak langsung anemia, termasuk kekurangan zat besi, pola makan buruk, dan kondisi medis tertentu.',
                'content' => 'Anemia bukan sekadar rasa lelah biasa...',
                'url' => '/storage/pdf/Penyebab-Anemia.pdf',
                'order' => 23,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
