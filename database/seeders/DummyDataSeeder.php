<?php

namespace Database\Seeders;

use App\Models\Dokumentasi;
use App\Models\Kehadiran;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use App\Models\Pimpinan;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Data Pimpinan Desa
        Pimpinan::updateOrCreate(
            ['id' => 1],
            [
                'nama_desa' => 'Desa Baji De Lovro',
                'nama_kepala_desa' => 'Dr. Baji De Lovro, M.Kom.',
            ]
        );
        // 2. Set Mode Presensi pada Pelatihan untuk Pengujian
        $pelatihanWeb = Pelatihan::where('judul', 'Dasar Pemrograman Web dengan Laravel')->first();
        if ($pelatihanWeb) {
            $pelatihanWeb->update(['presensi_by' => 'peserta']);
        }

        $pelatihanBisnis = Pelatihan::where('judul', 'Membuat Business Plan yang Menarik Investor')->first();
        if ($pelatihanBisnis) {
            $pelatihanBisnis->update(['presensi_by' => 'admin']);
        }

        $pelatihanTani = Pelatihan::where('judul', 'Pertanian Organik untuk Pemula')->first();
        if ($pelatihanTani) {
            $pelatihanTani->update(['presensi_by' => 'peserta']);
        }

        $pelatihanSehat = Pelatihan::where('judul', 'Pola Hidup Sehat untuk Lansia')->first();
        if ($pelatihanSehat) {
            $pelatihanSehat->update(['presensi_by' => 'admin']);
        }

        // 3. Ambil User Peserta
        $siti = User::where('email', 'siti@example.com')->first();
        $budi = User::where('email', 'budi@example.com')->first();
        $rina = User::where('email', 'rina@example.com')->first();

        // 4. Seed Pendaftaran, Kehadiran, & Sertifikat
        if ($pelatihanWeb && $siti && $budi && $rina) {
            // Siti - Disetujui & Hadir & Punya Sertifikat
            $daftar1 = Pendaftaran::updateOrCreate([
                'user_id' => $siti->id,
                'pelatihan_id' => $pelatihanWeb->id,
            ], [
                'tanggal_daftar' => '2026-06-20',
                'status' => 'disetujui',
            ]);

            $hadir1 = Kehadiran::updateOrCreate([
                'pendaftaran_id' => $daftar1->id,
            ], [
                'status_kehadiran' => 'hadir',
            ]);

            Sertifikat::updateOrCreate([
                'kehadiran_id' => $hadir1->id,
            ], [
                'nomor_sertifikat' => 'SIPPAD-' . $pelatihanWeb->id . '-0001-2026',
                'tanggal_terbit' => '2026-07-15',
            ]);

            // Budi - Disetujui & Hadir & Punya Sertifikat
            $daftar2 = Pendaftaran::updateOrCreate([
                'user_id' => $budi->id,
                'pelatihan_id' => $pelatihanWeb->id,
            ], [
                'tanggal_daftar' => '2026-06-21',
                'status' => 'disetujui',
            ]);

            $hadir2 = Kehadiran::updateOrCreate([
                'pendaftaran_id' => $daftar2->id,
            ], [
                'status_kehadiran' => 'hadir',
            ]);

            Sertifikat::updateOrCreate([
                'kehadiran_id' => $hadir2->id,
            ], [
                'nomor_sertifikat' => 'SIPPAD-' . $pelatihanWeb->id . '-0002-2026',
                'tanggal_terbit' => '2026-07-15',
            ]);

            // Rina - Menunggu Verifikasi (pending)
            Pendaftaran::updateOrCreate([
                'user_id' => $rina->id,
                'pelatihan_id' => $pelatihanWeb->id,
            ], [
                'tanggal_daftar' => '2026-06-22',
                'status' => 'pending',
            ]);
        }

        if ($pelatihanBisnis && $siti && $budi) {
            // Siti - Disetujui & Tidak Hadir
            $daftar3 = Pendaftaran::updateOrCreate([
                'user_id' => $siti->id,
                'pelatihan_id' => $pelatihanBisnis->id,
            ], [
                'tanggal_daftar' => '2026-06-20',
                'status' => 'disetujui',
            ]);

            Kehadiran::updateOrCreate([
                'pendaftaran_id' => $daftar3->id,
            ], [
                'status_kehadiran' => 'tidak_hadir',
            ]);

            // Budi - Ditolak
            Pendaftaran::updateOrCreate([
                'user_id' => $budi->id,
                'pelatihan_id' => $pelatihanBisnis->id,
            ], [
                'tanggal_daftar' => '2026-06-21',
                'status' => 'ditolak',
                'alasan_penolakan' => 'Persyaratan tidak lengkap atau kuota terbatas.',
            ]);
        }

        if ($pelatihanTani && $rina) {
            // Rina - Disetujui & Belum Presensi
            Pendaftaran::updateOrCreate([
                'user_id' => $rina->id,
                'pelatihan_id' => $pelatihanTani->id,
            ], [
                'tanggal_daftar' => '2026-06-25',
                'status' => 'disetujui',
            ]);
        }

        if ($pelatihanSehat && $siti && $budi) {
            // Siti & Budi - Pelatihan Selesai
            $daftar4 = Pendaftaran::updateOrCreate([
                'user_id' => $siti->id,
                'pelatihan_id' => $pelatihanSehat->id,
            ], [
                'tanggal_daftar' => '2026-06-10',
                'status' => 'disetujui',
            ]);

            $hadir4 = Kehadiran::updateOrCreate([
                'pendaftaran_id' => $daftar4->id,
            ], [
                'status_kehadiran' => 'hadir',
            ]);

            Sertifikat::updateOrCreate([
                'kehadiran_id' => $hadir4->id,
            ], [
                'nomor_sertifikat' => 'SIPPAD-' . $pelatihanSehat->id . '-0001-2026',
                'tanggal_terbit' => '2026-06-25',
            ]);

            $daftar5 = Pendaftaran::updateOrCreate([
                'user_id' => $budi->id,
                'pelatihan_id' => $pelatihanSehat->id,
            ], [
                'tanggal_daftar' => '2026-06-11',
                'status' => 'disetujui',
            ]);

            $hadir5 = Kehadiran::updateOrCreate([
                'pendaftaran_id' => $daftar5->id,
            ], [
                'status_kehadiran' => 'hadir',
            ]);

            Sertifikat::updateOrCreate([
                'kehadiran_id' => $hadir5->id,
            ], [
                'nomor_sertifikat' => 'SIPPAD-' . $pelatihanSehat->id . '-0002-2026',
                'tanggal_terbit' => '2026-06-25',
            ]);
        }

        // 5. Seed Foto Dokumentasi Dummy
        $dir = storage_path('app/public/dokumentasi');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        for ($i = 1; $i <= 2; $i++) {
            $filePath = $dir . "/sample-foto-{$i}.jpg";
            if (!file_exists($filePath)) {
                if (function_exists('imagecreate')) {
                    $img = imagecreate(600, 400);
                    $bg = ($i === 1) ? imagecolorallocate($img, 224, 13, 0) : imagecolorallocate($img, 49, 97, 146);
                    $text_color = imagecolorallocate($img, 255, 255, 255);
                    imagestring($img, 5, 180, 190, "Dokumentasi SIPPAD #{$i}", $text_color);
                    imagejpeg($img, $filePath);
                    imagedestroy($img);
                } else {
                    file_put_contents($filePath, base64_decode('/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wgALCAABAAEBAREA/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPxA='));
                }
            }
        }

        if ($pelatihanWeb) {
            Dokumentasi::updateOrCreate([
                'pelatihan_id' => $pelatihanWeb->id,
                'foto_kegiatan' => 'dokumentasi/sample-foto-1.jpg',
            ]);
            Dokumentasi::updateOrCreate([
                'pelatihan_id' => $pelatihanWeb->id,
                'foto_kegiatan' => 'dokumentasi/sample-foto-2.jpg',
            ]);
        }
    }
}
