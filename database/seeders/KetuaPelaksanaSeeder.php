<?php

namespace Database\Seeders;

use App\Models\Pelatihan;
use Illuminate\Database\Seeder;

class KetuaPelaksanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapping = [
            'Dasar Pemrograman Web dengan Laravel' => 'Ahmad Fauzi, S.T.',
            'Membuat Business Plan yang Menarik Investor' => 'Hendra Kusuma, M.B.A.',
            'Pertanian Organik untuk Pemula' => 'Siti Rahmawati, S.P.',
            'Digital Marketing untuk Destinasi Wisata Desa' => 'Dedy Kurniawan, S.E.',
            'Pola Hidup Sehat untuk Lansia' => 'Ners. Rina Melati, S.Kep.',
        ];

        foreach ($mapping as $judul => $ketua) {
            Pelatihan::where('judul', $judul)->update(['ketua_pelaksana' => $ketua]);
        }

        // Untuk pelatihan lain yang mungkin masih kosong/null ketua pelaksananya, berikan nama default
        Pelatihan::whereNull('ketua_pelaksana')
            ->orWhere('ketua_pelaksana', '')
            ->update(['ketua_pelaksana' => 'Ahmad Fauzi, S.T.']);
    }
}
