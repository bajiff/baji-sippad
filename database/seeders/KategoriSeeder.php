<?php

namespace Database\Seeders;

use App\Models\KategoriPelatihan;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            [
                'nama_kategori' => 'Teknologi Informasi',
            'deskripsi' => 'Pelatihan terkait komputer, programming, dan teknologi digital'
            ],
            ['nama_kategori' => 'Kewirausahaan', 'deskripsi' => 'Pelatihan untuk mengembangkan jiwa bisnis dan usaha'],
            ['nama_kategori' => 'Pertanian', 'deskripsi' => 'Pelatihan teknik pertanian modern dan berkelanjutan'],
            ['nama_kategori' => 'Pariwisata', 'deskripsi' => 'Pelatihan pengelolaan dan pemasaran pariwisata desa'],
            ['nama_kategori' => 'Kesehatan', 'deskripsi' => 'Pelatihan kesadaran kesehatan masyarakat desa'],
        ];

        foreach ($kategori as $item) {
            KategoriPelatihan::updateOrCreate(
                ['nama_kategori' => $item['nama_kategori']],
                $item
            );
        }
    }
}
