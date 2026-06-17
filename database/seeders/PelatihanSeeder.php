<?php

namespace Database\Seeders;

use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use Illuminate\Database\Seeder;

class PelatihanSeeder extends Seeder
{
    public function run(): void
    {
        $pelatihan = [
            [
                'kategori' => 'Teknologi Informasi',
                'judul' => 'Dasar Pemrograman Web dengan Laravel',
                'deskripsi' => 'Pelatihan intensif 5 hari tentang pengembangan web menggunakan Laravel framework. Peserta akan mempelajari routing, MVC, authentication, dan deployment.',
                'narasumber' => 'Budi Santoso, S.Kom',
                'lokasi' => 'Balai Desa Sari Mukti',
                'tanggal' => '2026-07-15',
                'jam' => '09:00',
                'kuota' => 30,
                'persyaratan' => 'Mengerti dasar komputer, membawa laptop sendiri',
                'status' => 'publish',
            ],
            [
                'kategori' => 'Kewirausahaan',
                'judul' => 'Membuat Business Plan yang Menarik Investor',
                'deskripsi' => 'Workshop tentang menyusun business plan profesional yang dapat menarik perhatian investor dan lembaga pembiayaan.',
                'narasumber' => 'Dewi Lestari, M.M.',
                'lokasi' => 'Aula Kecamatan Sari Mukti',
                'tanggal' => '2026-07-20',
                'jam' => '13:00',
                'kuota' => 25,
                'persyaratan' => 'Warga desa usia 18-45 tahun',
                'status' => 'publish',
            ],
            [
                'kategori' => 'Pertanian',
                'judul' => 'Pertanian Organik untuk Pemula',
                'deskripsi' => 'Pelatihan cara bertani organik yang benar dan menguntungkan. Termasuk praktik di lapangan.',
                'narasumber' => 'Ir. Suharto',
                'lokasi' => 'Lahan Pertanian Desa Sari Mukti',
                'tanggal' => '2026-08-01',
                'jam' => '08:00',
                'kuota' => 20,
                'persyaratan' => '',
                'status' => 'publish',
            ],
            [
                'kategori' => 'Pariwisata',
                'judul' => 'Digital Marketing untuk Destinasi Wisata Desa',
                'deskripsi' => 'Belajar mempromosikan potensi wisata desa melalui media sosial dan platform digital.',
                'narasumber' => 'Rina Permata, S.Par',
                'lokasi' => 'Balai Desa Sari Mukti',
                'tanggal' => '2026-08-10',
                'jam' => '09:00',
                'kuota' => 35,
                'persyaratan' => 'Memiliki akun media sosial aktif',
                'status' => 'draft',
            ],
            [
                'kategori' => 'Kesehatan',
                'judul' => 'Pola Hidup Sehat untuk Lansia',
                'deskripsi' => 'Edukasi tentang pola makan, olahraga ringan, dan manajemen stres untuk lansia.',
                'narasumber' => 'dr. Ani Wijaya',
                'lokasi' => 'Puskesmas Sari Mukti',
                'tanggal' => '2026-06-25',
                'jam' => '10:00',
                'kuota' => 40,
                'persyaratan' => '',
                'status' => 'selesai',
            ],
        ];

        foreach ($pelatihan as $item) {
            $kategori = KategoriPelatihan::where('nama_kategori', $item['kategori'])->first();
            if ($kategori) {
                Pelatihan::updateOrCreate(
                    ['judul' => $item['judul']],
                    [
                        'kategori_id' => $kategori->id,
                        'deskripsi' => $item['deskripsi'],
                        'narasumber' => $item['narasumber'],
                        'lokasi' => $item['lokasi'],
                        'tanggal' => $item['tanggal'],
                        'jam' => $item['jam'],
                        'kuota' => $item['kuota'],
                        'persyaratan' => $item['persyaratan'],
                        'status' => $item['status'],
                    ]
                );
            }
        }
    }
}
